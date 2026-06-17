<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\TicketController;
use App\Models\Tiket;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;

Route::bind('ticket', function ($value) {
    return \App\Models\Tiket::where('id_tiket', $value)->firstOrFail();
});

// Redirect root ke login
Route::get('/', function () {
    $problemSolved = Tiket::where('status', Tiket::STATUS_COMPLETED)->count();
    $tiketAktif = Tiket::whereIn('status', [
        Tiket::STATUS_APPROVED,
        Tiket::STATUS_IN_PROGRESS,
        Tiket::STATUS_CONFIRM,
    ])->count();
    $kategoriLayanan = Kategori::count();

    return view('welcome', compact('problemSolved', 'tiketAktif', 'kategoriLayanan'));
})->name('home');

Route::get('/track', function (\Illuminate\Http\Request $request) {
    $kode = $request->query('kode_tiket') ?? $request->query('ticket_id');
    $ticket = null;

    if ($kode) {
        $ticket = \App\Models\Tiket::with(['user', 'category', 'agent'])
            ->where('kode_tiket', $kode)
            ->orWhere('id_tiket', $kode)
            ->first();
    }

    return view('track', compact('ticket'));
})->name('track');

// Public stats endpoint: solved tickets per category per month (current year)
Route::get('/stats/categories-monthly', function (\Illuminate\Http\Request $request) {
    $year = $request->query('year', date('Y'));
    $month = $request->query('month'); // optional (1-12)

    $categories = \App\Models\Kategori::select('id', 'nama_kategori')->get();

    if ($month && is_numeric($month) && $month >= 1 && $month <= 12) {
        // Return counts per category for the specific month
        $rows = \Illuminate\Support\Facades\DB::table('tiket')
            ->selectRaw('id_kategori, COUNT(*) as cnt')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('status', \App\Models\Tiket::STATUS_COMPLETED)
            ->groupBy('id_kategori')
            ->get();

        // prepare labels as category names (top categories by count)
        $totals = [];
        foreach ($rows as $r) {
            $totals[$r->id_kategori] = (int) $r->cnt;
        }

        arsort($totals);
        $topCategoryIds = array_keys($totals);
        if (empty($topCategoryIds)) {
            $topCategoryIds = $categories->pluck('id')->toArray();
        }

        $labels = [];
        $data = [];
        $colors = ['#4dc9f6','#f67019','#f53794','#537bc4','#acc236','#166a8f','#00a950','#58595b'];
        $bg = [];
        foreach ($topCategoryIds as $idx => $catId) {
            $cat = $categories->firstWhere('id', $catId);
            $labels[] = $cat ? $cat->nama_kategori : 'Kategori ' . $catId;
            $data[] = $totals[$catId] ?? 0;
            $bg[] = $colors[$idx % count($colors)];
        }

        return response()->json([
            'mode' => 'by_category',
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Tiket Selesai',
                    'data' => $data,
                    'backgroundColor' => $bg,
                ]
            ],
        ]);
    }

    // Default: monthly stacked data for the year
    $rows = \Illuminate\Support\Facades\DB::table('tiket')
        ->selectRaw('id_kategori, MONTH(created_at) as month, COUNT(*) as cnt')
        ->whereYear('created_at', $year)
        ->where('status', \App\Models\Tiket::STATUS_COMPLETED)
        ->groupBy('id_kategori', 'month')
        ->get();

    $labels = array_map(function ($m) { return date('M', mktime(0,0,0,$m,1)); }, range(1,12));

    $totals = [];
    foreach ($rows as $r) {
        $totals[$r->id_kategori] = ($totals[$r->id_kategori] ?? 0) + $r->cnt;
    }

    arsort($totals);
    $topCategoryIds = array_slice(array_keys($totals), 0, 6);
    if (empty($topCategoryIds)) {
        $topCategoryIds = $categories->pluck('id')->take(6)->toArray();
    }

    $datasets = [];
    $colors = ['#4dc9f6','#f67019','#f53794','#537bc4','#acc236','#166a8f','#00a950','#58595b'];

    foreach ($topCategoryIds as $idx => $catId) {
        $cat = $categories->firstWhere('id', $catId);
        $monthly = array_fill(0, 12, 0);
        foreach ($rows as $r) {
            if ($r->id_kategori == $catId) {
                $monthly[$r->month - 1] = (int) $r->cnt;
            }
        }

        $datasets[] = [
            'label' => $cat ? $cat->nama_kategori : 'Kategori ' . $catId,
            'data' => $monthly,
            'backgroundColor' => $colors[$idx % count($colors)],
        ];
    }

    return response()->json([
        'mode' => 'by_month',
        'labels' => $labels,
        'datasets' => $datasets,
    ]);
});

Route::get('/login', function () {
    return redirect('/login');
})->name('login');

// Guest routes (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes (sudah login)
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $baseQuery = Tiket::query();
        } elseif ($user->isAgent()) {
            $baseQuery = Tiket::where('id_agent', $user->id);
        } else {
            $baseQuery = Tiket::where('id_user_create', $user->id);
        }

        return view('dashboard', [
            'total' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->where('status', '0')->count(),
            'approved' => (clone $baseQuery)->where('status', '1')->count(),
            'inProgress' => (clone $baseQuery)->where('status', '2')->count(),
            'completed' => (clone $baseQuery)->where('status', '4')->count(),
            'completedTickets' => (clone $baseQuery)
                ->where('status', '4')
                ->orderBy('updated_at', 'desc')
                ->take(10)
                ->get(),
            'categories' => Kategori::all(),
        ]);
    })->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    // TICKETS ROUTES (All roles)
    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('index');

        Route::get('/create', [TicketController::class, 'create'])->name('create');
        Route::get('/export', [TicketController::class, 'export'])->name('export');
        Route::post('/', [TicketController::class, 'store'])->name('store');
        Route::get('/{ticket}', [TicketController::class, 'show'])->name('show');
        Route::post('/{ticket}/confirm', [TicketController::class, 'confirmComplete'])->name('confirm');
    });

    // ===============================================
    // AGENT ROUTES
    // ===============================================
    Route::prefix('agent')->name('agent.')->group(function () {
        Route::get('/tickets', [AgentController::class, 'index'])->name('tickets');
        Route::get('/tickets/{id}', [AgentController::class, 'show'])->name('tickets.show');
        Route::put('/tickets/{id}/status', [AgentController::class, 'updateStatus'])->name('tickets.updateStatus');
        Route::post('/tickets/{id}/comment', [AgentController::class, 'addComment'])->name('tickets.addComment');
    });

    Route::post('/tickets/{ticket}/comment', [TicketController::class, 'addComment'])
    ->name('tickets.addComment');



    // ===============================================
    // ADMIN ROUTES
    // ===============================================
    Route::middleware('admin')->group(function () {
        // User Management
        Route::resource('users', UserController::class);

        // Category Management
        Route::resource('categories', CategoryController::class);

        // Ticket Management (Admin only)
        Route::prefix('tickets')->name('tickets.')->group(function () {
            // List tiket pending yang perlu di-assign
            Route::get('/pending', [TicketController::class, 'pending'])->name('pending');

            // Assign agent ke tiket
            Route::post('/{ticket}/assign', [TicketController::class, 'assignAgent'])->name('assignAgent');

            // Update status tiket (admin bisa update semua)
            Route::post('/{ticket}/update-status', [TicketController::class, 'updateStatus'])->name('updateStatus');
            Route::put('/tickets/{id}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
            Route::post('/tickets/{ticket}/comment', [TicketController::class, 'addComment'])->name('tickets.addComment');
        });
    });
});

//FAQ/faqs route


Route::resource('faq', FaqController::class);

// ADMIN
Route::middleware(['auth'])->group(function () {
    Route::resource('admin/faq', FaqController::class);
});

// USER (login)
Route::middleware(['auth'])->group(function () {
    Route::get('/faq-user', [FaqController::class, 'user'])->name('faq.user');
});

// PUBLIC (tanpa login)
Route::get('/faq-public', [FaqController::class, 'public'])->name('faq.public');

