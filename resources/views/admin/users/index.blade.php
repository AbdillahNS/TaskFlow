<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800">👥 Kelola Pegawai</h2>
                <p class="text-sm text-gray-400 mt-0.5">{{ $users->count() }} pegawai terdaftar</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Tambah Pegawai
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">

            {{-- Pegawai Cards --}}
            @if($users->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm text-center py-20 text-gray-400">
                    <div class="w-20 h-20 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-9 h-9 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <p class="text-lg font-semibold text-gray-600">Belum ada pegawai terdaftar</p>
                    <p class="text-sm mt-1">Tambahkan akun pegawai untuk mulai assign tugas.</p>
                    <a href="{{ route('admin.users.create') }}" class="inline-block mt-5 px-6 py-2.5 bg-purple-600 text-white text-sm font-semibold rounded-xl hover:bg-purple-700 transition-colors">
                        Tambah Pegawai
                    </a>
                </div>
            @else
                <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($users as $user)
                        <div class="card-lift bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            {{-- Top stripe --}}
                            <div class="h-2 bg-gradient-to-r from-purple-400 via-indigo-500 to-violet-500"></div>
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center text-white font-extrabold text-xl shadow-md">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800">{{ $user->name }}</h4>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <button
                                        onclick="confirmDeleteUser('{{ route('admin.users.destroy', $user->id) }}', '{{ addslashes($user->name) }}')"
                                        class="p-2 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Pegawai">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>

                                <div class="mt-5 pt-5 border-t border-gray-50 grid grid-cols-2 gap-3">
                                    <div class="bg-indigo-50 rounded-xl px-4 py-3 text-center">
                                        <p class="text-2xl font-extrabold text-indigo-600">{{ $user->assigned_tasks_count }}</p>
                                        <p class="text-xs text-indigo-400 font-medium mt-0.5">Total Tugas</p>
                                    </div>
                                    <div class="bg-gray-50 rounded-xl px-4 py-3 text-center">
                                        <p class="text-xs text-gray-500 font-medium">Bergabung</p>
                                        <p class="text-xs font-bold text-gray-700 mt-1">{{ $user->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>

                                {{-- Assign task quick link --}}
                                <a href="{{ route('admin.tasks.create') }}?pegawai={{ $user->id }}"
                                    class="mt-4 w-full inline-flex items-center justify-center gap-2 bg-purple-50 hover:bg-purple-100 text-purple-700 text-sm font-semibold py-2 rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Beri Tugas
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <form id="delete-user-form" method="POST" class="hidden">@csrf @method('DELETE')</form>

    <script>
    async function confirmDeleteUser(url, name) {
        const ok = await showConfirm({
            title: 'Hapus Pegawai?',
            message: `Akun "${name}" beserta semua tugasnya akan dihapus permanen.`,
            okLabel: 'Ya, Hapus', okClass: 'bg-red-500 hover:bg-red-600', icon: 'danger',
        });
        if (ok) { document.getElementById('delete-user-form').action = url; document.getElementById('delete-user-form').submit(); }
    }
    </script>
</x-app-layout>
