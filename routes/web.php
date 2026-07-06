<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PegawaiTaskController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

// Halaman welcome
Route::get('/', function () {
    return view('welcome');
});

// Dashboard utama — redirect ke panel sesuai role
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('pegawai.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (semua user)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── ADMIN ROUTES ───────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard admin
        Route::get('/dashboard', function () {
            $stats = [
                'total'     => \App\Models\Task::count(),
                'pending'   => \App\Models\Task::where('status', 'pending')->count(),
                'progress'  => \App\Models\Task::where('status', 'progress')->count(),
                'completed' => \App\Models\Task::where('status', 'completed')->count(),
                'pegawai'   => \App\Models\User::where('role', 'pegawai')->count(),
            ];
            $recentTasks = \App\Models\Task::with(['employee'])->latest()->limit(5)->get();
            return view('admin.dashboard', compact('stats', 'recentTasks'));
        })->name('dashboard');

        // CRUD Tugas
        Route::resource('tasks', TaskController::class);

        // Kelola Pegawai
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });

// ─── PEGAWAI ROUTES ──────────────────────────────────────────────
Route::middleware(['auth', 'role:pegawai'])
    ->prefix('pegawai')
    ->name('pegawai.')
    ->group(function () {

        // Dashboard pegawai
        Route::get('/dashboard', function () {
            $tasks = \App\Models\Task::where('assigned_to', auth()->id())->get();
            $stats = [
                'total'     => $tasks->count(),
                'pending'   => $tasks->where('status', 'pending')->count(),
                'progress'  => $tasks->where('status', 'progress')->count(),
                'completed' => $tasks->where('status', 'completed')->count(),
            ];
            return view('pegawai.dashboard', compact('stats'));
        })->name('dashboard');

        // Daftar tugas pegawai
        Route::get('/tasks', [PegawaiTaskController::class, 'index'])->name('tasks.index');

        // Mulai kerjakan tugas (pending → progress)
        Route::put('/tasks/{task}/progress', [PegawaiTaskController::class, 'inProgress'])
            ->name('tasks.progress');

        // Selesaikan tugas
        Route::put('/tasks/{task}/complete', [PegawaiTaskController::class, 'complete'])
            ->name('tasks.complete');
    });

require __DIR__ . '/auth.php';
