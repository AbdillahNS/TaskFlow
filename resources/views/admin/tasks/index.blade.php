<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800">📋 Kelola Tugas</h2>
                <p class="text-sm text-gray-400 mt-0.5">{{ $tasks->count() }} tugas ditemukan</p>
            </div>
            <a href="{{ route('admin.tasks.create') }}"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Tugas
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">

            {{-- ── Stat Cards ── --}}
            <div class="grid grid-cols-4 gap-4">
                @foreach([
                    ['Total', $stats['total'],     'indigo', '#'],
                    ['Pending',  $stats['pending'],    'amber',  '?status=pending'],
                    ['Progress', $stats['progress'],   'blue',   '?status=progress'],
                    ['Selesai',  $stats['completed'],  'emerald','?status=completed'],
                ] as [$lbl, $val, $clr, $href])
                <div class="card-lift bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4 cursor-pointer"
                     onclick="filterStatus('{{ $lbl === 'Total' ? '' : strtolower($lbl === 'Selesai' ? 'completed' : $lbl) }}')">
                    <p class="text-xs font-semibold text-{{ $clr }}-500 uppercase tracking-wide">{{ $lbl }}</p>
                    <p class="text-3xl font-extrabold text-{{ $clr }}-600 mt-1.5">{{ $val }}</p>
                    <div class="mt-2 h-1 rounded-full bg-{{ $clr }}-100">
                        <div class="h-1 rounded-full bg-{{ $clr }}-400"
                             style="width: {{ $stats['total'] > 0 ? ($val / $stats['total'] * 100) : 0 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- ── Filter Bar ── --}}
            <div class="flex items-center gap-2 bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-3">
                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
                <span class="text-xs font-semibold text-gray-400 mr-2">Filter:</span>
                @foreach([['all','Semua','gray'],['pending','Pending','amber'],['progress','Progress','blue'],['completed','Selesai','emerald']] as [$v,$l,$c])
                <button onclick="filterStatus('{{ $v === 'all' ? '' : $v }}')"
                    class="filter-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-colors
                           {{ $v === 'all' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                    data-filter="{{ $v === 'all' ? '' : $v }}">
                    {{ $l }}
                </button>
                @endforeach
            </div>

            {{-- ── Table ── --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                @if($tasks->isEmpty())
                    <div class="text-center py-20 text-gray-400">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-9 h-9 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                        </div>
                        <p class="text-lg font-semibold text-gray-600">Belum ada tugas</p>
                        <p class="text-sm mt-1">Mulai dengan membuat tugas pertama.</p>
                        <a href="{{ route('admin.tasks.create') }}" class="inline-block mt-5 px-6 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-colors">
                            Buat Tugas Sekarang
                        </a>
                    </div>
                @else
                    <table class="w-full text-sm" id="tasks-table">
                        <thead>
                            <tr class="bg-gray-50/80 text-left border-b border-gray-100">
                                <th class="px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">No</th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Tugas</th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Pegawai</th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Deadline</th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                                <th class="px-6 py-3.5 text-xs font-semibold text-gray-400 uppercase tracking-wide text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50" id="tasks-tbody">
                            @foreach($tasks as $i => $task)
                                <tr class="hover:bg-indigo-50/30 transition-colors group task-row" data-status="{{ $task->status }}">
                                    <td class="px-6 py-4 text-gray-400 font-medium text-xs">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-6 py-4">
                                        <div class="max-w-xs">
                                            <p class="font-semibold text-gray-800 leading-snug">{{ $task->title }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $task->description }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center text-white font-bold text-xs shrink-0">
                                                {{ strtoupper(substr($task->employee->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-700 text-sm">{{ $task->employee->name ?? '-' }}</p>
                                                <p class="text-xs text-gray-400">{{ $task->employee->email ?? '' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php $late = $task->deadline->isPast() && $task->status !== 'completed'; @endphp
                                        <div>
                                            <p class="font-medium {{ $late ? 'text-red-600' : 'text-gray-700' }} text-sm">
                                                {{ $task->deadline->format('d M Y') }}
                                            </p>
                                            <p class="text-xs mt-0.5 {{ $late ? 'text-red-400' : 'text-gray-400' }}">
                                                {{ $late ? '⚠️ Terlambat' : $task->deadline->diffForHumans() }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold
                                            @if($task->status==='completed') bg-emerald-100 text-emerald-700
                                            @elseif($task->status==='progress') bg-blue-100 text-blue-700
                                            @else bg-amber-100 text-amber-700 @endif">
                                            @if($task->status==='pending')
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Pending
                                            @elseif($task->status==='progress')
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span> Progress
                                            @else
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Selesai
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-1">
                                            {{-- Detail --}}
                                            <a href="{{ route('admin.tasks.show', $task) }}"
                                                class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Detail">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            {{-- Edit --}}
                                            <a href="{{ route('admin.tasks.edit', $task) }}"
                                                class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            {{-- Delete (modal) --}}
                                            <button type="button"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Hapus"
                                                onclick="confirmDelete('{{ route('admin.tasks.destroy', $task) }}', '{{ addslashes($task->title) }}')">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Empty filter state --}}
                    <div id="no-filter-result" class="hidden text-center py-14 text-gray-400">
                        <p class="font-medium">Tidak ada tugas dengan filter ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Hidden delete form --}}
    <form id="delete-form" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
    // ── Filter rows by status ─────────────────────────────────────
    function filterStatus(status) {
        document.querySelectorAll('.filter-btn').forEach(btn => {
            const match = btn.dataset.filter === status;
            btn.classList.toggle('bg-indigo-600', match);
            btn.classList.toggle('text-white', match);
            btn.classList.toggle('bg-gray-100', !match);
            btn.classList.toggle('text-gray-600', !match);
        });

        let visible = 0;
        document.querySelectorAll('.task-row').forEach(row => {
            const show = !status || row.dataset.status === status;
            row.classList.toggle('hidden', !show);
            if (show) visible++;
        });
        const empty = document.getElementById('no-filter-result');
        if (empty) empty.classList.toggle('hidden', visible > 0);
    }

    // ── Delete confirmation modal ─────────────────────────────────
    async function confirmDelete(url, title) {
        const ok = await showConfirm({
            title: 'Hapus Tugas?',
            message: `Tugas "${title}" akan dihapus permanen dan tidak bisa dikembalikan.`,
            okLabel: 'Ya, Hapus',
            okClass: 'bg-red-500 hover:bg-red-600',
            icon: 'danger',
        });
        if (ok) {
            const form = document.getElementById('delete-form');
            form.action = url;
            form.submit();
        }
    }
    </script>
</x-app-layout>
