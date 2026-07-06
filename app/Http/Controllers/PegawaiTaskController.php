<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class PegawaiTaskController extends Controller
{
    /**
     * Tampilkan daftar tugas milik pegawai yang sedang login.
     */
    public function index()
    {
        $tasks = Task::with('admin')
            ->where('assigned_to', auth()->id())
            ->latest()
            ->get();

        $stats = [
            'total'     => $tasks->count(),
            'pending'   => $tasks->where('status', 'pending')->count(),
            'progress'  => $tasks->where('status', 'progress')->count(),
            'completed' => $tasks->where('status', 'completed')->count(),
        ];

        return view('pegawai.tasks.index', compact('tasks', 'stats'));
    }

    /**
     * Tandai tugas sebagai selesai.
     */
    public function complete(Task $task)
    {
        // Pastikan hanya pemilik tugas yang bisa menyelesaikan
        if ($task->assigned_to !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }

        $task->update(['status' => 'completed']);

        return redirect()->route('pegawai.tasks.index')
            ->with('success', 'Selamat! Tugas berhasil ditandai selesai. 🎉');
    }

    /**
     * Ubah status tugas menjadi "In Progress".
     */
    public function inProgress(Task $task)
    {
        if ($task->assigned_to !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }

        if ($task->status === 'pending') {
            $task->update(['status' => 'progress']);
        }

        return redirect()->route('pegawai.tasks.index')
            ->with('success', 'Tugas sedang dikerjakan.');
    }
}
