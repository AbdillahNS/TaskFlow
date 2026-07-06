<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Tampilkan semua tugas beserta statistik.
     */
    public function index()
    {
        $tasks = Task::with(['employee', 'admin'])->latest()->get();

        $stats = [
            'total'     => $tasks->count(),
            'pending'   => $tasks->where('status', 'pending')->count(),
            'progress'  => $tasks->where('status', 'progress')->count(),
            'completed' => $tasks->where('status', 'completed')->count(),
        ];

        return view('admin.tasks.index', compact('tasks', 'stats'));
    }

    /**
     * Tampilkan form tambah tugas.
     */
    public function create()
    {
        $pegawai = User::where('role', 'pegawai')->get();
        return view('admin.tasks.create', compact('pegawai'));
    }

    /**
     * Simpan tugas baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
            'deadline'    => 'required|date|after_or_equal:today',
            'status'      => 'required|in:pending,progress,completed',
        ], [
            'title.required'       => 'Judul tugas wajib diisi.',
            'description.required' => 'Deskripsi tugas wajib diisi.',
            'assigned_to.required' => 'Pilih pegawai yang ditugaskan.',
            'deadline.required'    => 'Deadline wajib diisi.',
            'deadline.after_or_equal' => 'Deadline tidak boleh sebelum hari ini.',
        ]);

        Task::create([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'assigned_to' => $validated['assigned_to'],
            'assigned_by' => auth()->id(),
            'deadline'    => $validated['deadline'],
            'status'      => $validated['status'],
        ]);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Tugas berhasil dibuat!');
    }

    /**
     * Tampilkan detail tugas.
     */
    public function show(string $id)
    {
        $task = Task::with(['employee', 'admin'])->findOrFail($id);
        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Tampilkan form edit tugas.
     */
    public function edit(string $id)
    {
        $task    = Task::findOrFail($id);
        $pegawai = User::where('role', 'pegawai')->get();
        return view('admin.tasks.edit', compact('task', 'pegawai'));
    }

    /**
     * Update tugas.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
            'deadline'    => 'required|date',
            'status'      => 'required|in:pending,progress,completed',
        ], [
            'title.required'       => 'Judul tugas wajib diisi.',
            'description.required' => 'Deskripsi tugas wajib diisi.',
            'assigned_to.required' => 'Pilih pegawai yang ditugaskan.',
            'deadline.required'    => 'Deadline wajib diisi.',
        ]);

        $task->update($validated);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Hapus tugas.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Tugas berhasil dihapus!');
    }
}

