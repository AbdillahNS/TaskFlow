<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $admin   = User::where('role', 'admin')->first();
        $pegawai = User::where('role', 'pegawai')->first();

        if (!$admin || !$pegawai) return;

        $tasks = [
            [
                'title'       => 'Buat Laporan Keuangan Bulanan',
                'description' => 'Membuat laporan keuangan lengkap untuk bulan Juni 2026, termasuk neraca dan laporan laba rugi perusahaan.',
                'status'      => 'progress',
                'deadline'    => '2026-07-15',
            ],
            [
                'title'       => 'Desain Presentasi Q3',
                'description' => 'Membuat slide presentasi untuk meeting Q3 dengan stakeholder. Gunakan template perusahaan terbaru.',
                'status'      => 'pending',
                'deadline'    => '2026-07-20',
            ],
            [
                'title'       => 'Update Database Pelanggan',
                'description' => 'Memperbarui data pelanggan di sistem CRM, termasuk validasi nomor telepon dan email aktif.',
                'status'      => 'completed',
                'deadline'    => '2026-07-10',
            ],
            [
                'title'       => 'Audit Keamanan Server',
                'description' => 'Melakukan pengecekan keamanan menyeluruh pada server produksi dan membuat laporan temuan.',
                'status'      => 'pending',
                'deadline'    => '2026-07-25',
            ],
        ];

        foreach ($tasks as $task) {
            Task::create([
                'title'       => $task['title'],
                'description' => $task['description'],
                'assigned_by' => $admin->id,
                'assigned_to' => $pegawai->id,
                'deadline'    => $task['deadline'],
                'status'      => $task['status'],
            ]);
        }
    }
}
