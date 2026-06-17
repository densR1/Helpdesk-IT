<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Models\User;
use App\Models\TicketComment;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $query = Tiket::with(['user', 'category', 'agent']);

        if (auth()->user()->isAdmin()) {
        } elseif (auth()->user()->isAgent()) {
            return redirect()->route('agent.tickets');
        } else {
            $query->where('id_user_create', auth()->id());
        }

        $tickets = $query->latest()->get();

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $kategori = \App\Models\Kategori::all();
        return view('tickets.create', compact('kategori'));
    }
    public function export(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|integer|in:' . implode(',', [
                Tiket::STATUS_PENDING,
                Tiket::STATUS_APPROVED,
                Tiket::STATUS_IN_PROGRESS,
                Tiket::STATUS_CONFIRM,
                Tiket::STATUS_COMPLETED,
            ]),
        ]);

        $query = Tiket::with(['user', 'category', 'agent']);

        if (isset($validated['status']) && $validated['status'] !== null) {
            $query->where('status', $validated['status']);
        }
        if (!empty($validated['start_date'])) {
            $query->whereDate('created_at', '>=', $validated['start_date']);
        }
        if (!empty($validated['end_date'])) {
            $query->whereDate('created_at', '<=', $validated['end_date']);
        }

        $tickets = $query->latest()->get();

        $filename = 'tiket_' . now()->format('Ymd_His') . '.xlsx';

        $columns = [
            'No',
            'Kode Tiket',
            'Judul',
            'Kategori',
            'Pembuat',
            'Agent',
            'Status',
            'Tanggal Dibuat',
            'Tanggal Selesai',
        ];

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Tiket');

        // Header
        $sheet->fromArray($columns, null, 'A1');
        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($columns));
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '22328D'],
            ],
            'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(22);

        $row = 2;
        foreach ($tickets as $i => $t) {
            $sheet->fromArray([
                $i + 1,
                $t->kode_tiket ?? '-',
                $t->judul,
                $t->category->nama_kategori ?? '-',
                $t->user->name ?? '-',
                $t->agent->name ?? '-',
                $t->getStatusLabel(),
                optional($t->created_at)->format('Y-m-d H:i'),
                optional($t->date_selesai)->format('Y-m-d H:i'),
            ], null, "A{$row}");
            $row++;
        }

        foreach (range(1, count($columns)) as $colIdx) {
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        $lastRow = max($row - 1, 1);
        $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'D9D9D9'],
                ],
            ],
        ]);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategori,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'id_user_create' => 'nullable|exists:users,id',
        ]);

        // Tentukan pembuat tiket
        $idUserCreate = auth()->user()->isAdmin()
            ? $validated['id_user_create']
            : auth()->id();

        // Upload file
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        // Create ticket first (we need id_tiket and created_at to build kode_tiket)
        $ticket = Tiket::create([
            'id_user_create' => $idUserCreate,
            'id_kategori' => $validated['id_kategori'],
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'attachment' => $attachmentPath,
            'status' => Tiket::STATUS_PENDING,
        ]);

        // Generate kode_tiket: 2-letter uppercase from nama_kategori + id_tiket + id_user + id_kategori + created_at(DDMMYYYY)
        $category = \App\Models\Kategori::find($validated['id_kategori']);
        $abbr = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $category->nama_kategori ?? ''), 0, 2));
        $date = $ticket->created_at->format('dmY');
        $kodeTiket = $abbr . $ticket->id_tiket . $ticket->id_user_create . $ticket->id_kategori . $date;

        $ticket->update(['kode_tiket' => $kodeTiket]);

        return redirect()->route('tickets.index')
            ->with('success', 'Tiket berhasil dibuat! Menunggu persetujuan admin.');
    }


    // Detail tiket
    public function show(Tiket $ticket)
    {
        if (auth()->user()->isUser() && $ticket->id_user_create !== auth()->id()) {
            abort(403);
        }

        if (auth()->user()->isAgent() && $ticket->id_agent !== auth()->id()) {
            abort(403);
        }

        return view('tickets.show', compact('ticket'));
    }

    // Admin: Tiket pending yang perlu diassign
    public function pending()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $tickets = Tiket::with(['user', 'category'])
            ->where('status', Tiket::STATUS_PENDING)
            ->whereNull('id_agent')
            ->latest()
            ->paginate(10);

        return view('tickets.pending', compact('tickets'));
    }

    // Admin: assign agent
    public function assignAgent(Request $request, Tiket $ticket)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'id_agent' => 'required|exists:users,id',
        ]);

        $ticket->update([
            'id_agent' => $validated['id_agent'],
            'id_admin' => auth()->id(),
            'status' => Tiket::STATUS_APPROVED,
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Agent berhasil diassign!');
    }
    public function updateStatus(Request $request, Tiket $ticket)
    {
        if (!auth()->user()->isAdmin() && $ticket->id_agent !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|integer|in:' . implode(',', [
                Tiket::STATUS_PENDING,
                Tiket::STATUS_APPROVED,
                Tiket::STATUS_IN_PROGRESS,
                Tiket::STATUS_CONFIRM,
                Tiket::STATUS_COMPLETED
            ]),

            'note' => 'nullable|string',
        ]);

        $updateData = [
            'status' => $validated['status'],
        ];

        if ($request->filled('note')) {
            $updateData['note'] = $validated['note'];
        }

        if ($validated['status'] == Tiket::STATUS_COMPLETED) {
            $updateData['date_selesai'] = now();
        }

        $ticket->update($updateData);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Status tiket berhasil diupdate!');
    }

    // User: konfirmasi selesai
    public function confirmComplete(Tiket $ticket)
    {
        if ($ticket->id_user_create !== auth()->id()) {
            abort(403);
        }

        $ticket->update([
            'status' => Tiket::STATUS_COMPLETED,
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Tiket telah diselesaikan!');
    }
    // public function addComment(Request $request, Tiket $ticket)
    // {
    //     // Pastikan hanya pembuat tiket yang bisa komentar
    //     if ($ticket->id_user_create !== auth()->id()) {
    //         abort(403);
    //     }

    //     $request->validate([
    //         'komentar' => 'required|string',
    //     ]);

    //     $ticket->comments()->create([
    //         'user_id' => auth()->id(),
    //         'komentar' => $request->komentar,
    //     ]);

    //     return back()->with('success', 'Komentar berhasil dikirim');
    // }
    public function addComment(Request $request, Tiket $tiket)
    {
        if ($tiket->isPending()) {
            return back()->with('error', 'Komentar belum tersedia. Tiket harus diproses agent terlebih dahulu.');
        }

        $validated = $request->validate([
            'komentar' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('comment_attachments', 'public');
        }

        TicketComment::create([
            'tiket_id' => $tiket->id_tiket,
            'user_id' => auth()->id(),
            'komentar' => $validated['komentar'],
            'attachment' => $path,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan');
    }
}
