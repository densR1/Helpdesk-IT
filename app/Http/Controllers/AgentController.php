<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TicketComment;


class AgentController extends Controller
{
    public function index()
    {
        $agentId = Auth::id();

        $tiket = Tiket::with(['user', 'category', 'agent'])
            ->where('id_agent', $agentId)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('agent.index', compact('tiket'));
    }

    public function show($id)
    {
        $tiket = Tiket::with(['user', 'category', 'agent'])
            ->where('id_tiket', $id)
            ->firstOrFail();

        return view('agent.show', compact('tiket'));
    }

    // public function updateStatus(Request $request, $id)
    // {
    //     $request->validate([
    //         'status' => 'required|string',
    //     ]);

    //     $tiket = Tiket::where('id_tiket', $id)->firstOrFail();
    //     $tiket->status = $request->status;
    //     $tiket->save();

    //     return redirect()->route('agent.tickets.show', $id)
    //         ->with('success', 'Status berhasil diperbarui');
    // }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|integer|in:0,1,2,3,4',
        ]);

        $tiket = Tiket::where('id_tiket', $id)->firstOrFail();
        $tiket->status = $request->status; // langsung angka
        $tiket->save();

        return redirect()->route('agent.tickets.show', $id)
            ->with('success', 'Status berhasil diperbarui');
    }

    public function addComment(Request $request, $id)
    {
        $validated = $request->validate([
            'komentar' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('comment_attachments', 'public');
        }

        TicketComment::create([
            'tiket_id' => $id,              // gunakan $id, bukan $tiket
            'user_id' => auth()->id(),
            'komentar' => $validated['komentar'],
            'attachment' => $path,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim');
    }


}
