<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.tasks.index') }}" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h2 class="font-bold text-xl text-gray-800">🔍 Detail Tugas</h2>
                <p class="text-sm text-gray-400 mt-0.5">Dibuat {{ $task->created_at->diffForHumans() }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-5">

            {{-- ── Status Banner ── --}}
            <div class="@if($task->status==='completed') bg-gradient-to-r from-emerald-500 to-teal-500
                         @elseif($task->status==='progress') bg-gradient-to-r from-blue-500 to-indigo-500
                         @else bg-gradient-to-r from-amber-400 to-orange-400 @endif
                         rounded-2xl p-5 text-white flex items-center justify-between shadow-md">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest opacity-80">Status Saat Ini</p>
                    <p class="text-2xl font-extrabold mt-0.5">
                        @if($task->status==='pending') ⏳ Pending
                        @elseif($task->status==='progress') 🔄 Sedang Dikerjakan
                        @else ✅ Selesai @endif
                    </p>
                </div>
                <div class="text-right text-sm opacity-80">
                    <p>Deadline</p>
                    <p class="font-bold text-base text-white">{{ $task->deadline->format('d M Y') }}</p>
                    @if($task->status !== 'completed')
                        <p class="text-xs">{{ $task->deadline->isPast() ? '⚠️ Terlambat' : $task->deadline->diffForHumans() }}</p>
                    @endif
                </div>
            </div>

            {{-- ── Main Card ── --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-7 py-6 border-b border-gray-50">
                    <h3 class="text-xl font-extrabold text-gray-900">{{ $task->title }}</h3>
                </div>

                <div class="px-7 py-6 space-y-6">

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Deskripsi Tugas</label>
                        <div class="bg-gray-50 rounded-xl p-5 text-gray-700 text-sm leading-relaxed border border-gray-100">
                            {{ $task->description }}
                        </div>
                    </div>

                    {{-- Info Grid --}}
                    <div class="grid grid-cols-2 gap-4">
                        {{-- Ditugaskan ke --}}
                        <div class="bg-purple-50 border border-purple-100 rounded-xl p-4">
                            <label class="block text-xs font-semibold text-purple-400 uppercase tracking-wide mb-3">Ditugaskan Kepada</label>
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center text-white font-bold shadow-sm">
                                    {{ strtoupper(substr($task->employee->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">{{ $task->employee->name ?? '-' }}</p>
                                    <p class="text-xs text-purple-400">{{ $task->employee->email ?? '' }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Dibuat oleh --}}
                        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4">
                            <label class="block text-xs font-semibold text-indigo-400 uppercase tracking-wide mb-3">Dibuat Oleh</label>
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white font-bold shadow-sm">
                                    {{ strtoupper(substr($task->admin->name ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">{{ $task->admin->name ?? '-' }}</p>
                                    <p class="text-xs text-indigo-400">Admin</p>
                                </div>
                            </div>
                        </div>

                        {{-- Deadline --}}
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-4">
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Deadline</label>
                            <p class="font-bold text-gray-800 text-lg">{{ $task->deadline->format('d F Y') }}</p>
                            @if($task->status !== 'completed')
                                <p class="text-xs mt-1 {{ $task->deadline->isPast() ? 'text-red-500 font-semibold' : 'text-gray-400' }}">
                                    {{ $task->deadline->isPast() ? '⚠️ Sudah melewati deadline' : $task->deadline->diffForHumans() }}
                                </p>
                            @else
                                <p class="text-xs mt-1 text-emerald-500">✅ Berhasil diselesaikan</p>
                            @endif
                        </div>

                        {{-- Dibuat pada --}}
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-4">
                            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Tanggal Dibuat</label>
                            <p class="font-bold text-gray-800 text-lg">{{ $task->created_at->format('d F Y') }}</p>
                            <p class="text-xs text-gray-400 mt-1">Pukul {{ $task->created_at->format('H:i') }} WIB</p>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="px-7 py-5 bg-gray-50/60 border-t border-gray-100 flex flex-wrap gap-3">
                    <a href="{{ route('admin.tasks.edit', $task) }}"
                        class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Tugas
                    </a>
                    <button type="button"
                        onclick="confirmDelete('{{ route('admin.tasks.destroy', $task) }}', '{{ addslashes($task->title) }}')"
                        class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus Tugas
                    </button>
                    <a href="{{ route('admin.tasks.index') }}"
                        class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 text-gray-700 font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors border border-gray-200">
                        ← Kembali
                    </a>
                </div>
            </div>

        </div>
    </div>

    <form id="delete-form" method="POST" class="hidden">@csrf @method('DELETE')</form>

    <script>
    async function confirmDelete(url, title) {
        const ok = await showConfirm({
            title: 'Hapus Tugas?',
            message: `Tugas "${title}" akan dihapus permanen dan tidak bisa dikembalikan.`,
            okLabel: 'Ya, Hapus', okClass: 'bg-red-500 hover:bg-red-600', icon: 'danger',
        });
        if (ok) { document.getElementById('delete-form').action = url; document.getElementById('delete-form').submit(); }
    }
    </script>
</x-app-layout>
