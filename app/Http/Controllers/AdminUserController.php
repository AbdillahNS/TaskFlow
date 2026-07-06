<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Tampilkan semua pegawai.
     */
    public function index()
    {
        $users = User::where('role', 'pegawai')->withCount('assignedTasks')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Tampilkan form tambah pegawai.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan pegawai baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required'      => 'Nama pegawai wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'pegawai',
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pegawai berhasil ditambahkan!');
    }

    /**
     * Hapus pegawai.
     */
    public function destroy(string $id)
    {
        $user = User::where('role', 'pegawai')->findOrFail($id);

        // Hapus juga task yang terassign ke pegawai ini
        Task::where('assigned_to', $user->id)->delete();

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pegawai berhasil dihapus.');
    }
}

