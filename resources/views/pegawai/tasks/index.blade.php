<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800">📋 Tugas Saya</h2>
                <p class="text-sm text-gray-400 mt-0.5">{{ $tasks->count() }} tugas diberikan kepadamu</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ── Stat Cards ── --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach([
                    ['Total',    $stats['total'],     'indigo', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    ['Pending',  $stats['pending'],   'amber',  'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['Progress', $stats['progress'],  'blue',   'M13 10V3L4 14h7v7l9-11h-7z'],
                    ['Selesai',  $stats['completed'], 'emerald','M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ] as [$lbl, $val, $clr, $path])
                <div class="card-lift bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-{{ $clr }}-500 uppercase tracking-wide">{{ $lbl }}</p>
                            <p class="text-3xl font-extrabold text-{{ $clr }}-600 mt-1.5">{{ $val }}</p>
                        </div>
                        <div class="bg-{{ $clr }}-50 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-{{ $clr }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/>
                            </svg>
                        </div>
                    </div>
                    @if($stats['total'] > 0)
                        <div class="mt-3 h-1.5 rounded-full bg-{{ $clr }}-100">
                            <div class="h-1.5 rounded-full bg-{{ $clr }}-400" style="width: {{ ($val / $stats['total']) * 100 }}%"></div>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>

            {{-- ── Task Cards ── --}}
            @if($tasks->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm text-center py-20">
                    <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-9 h-9 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                    </div>
                    <p class="text-lg font-semibold text-gray-600">Belum ada tugas untukmu</p>
                    <p class="text-sm text-gray-400 mt-1">Tugas yang diberikan admin akan muncul di sini.</p>
                </div>
            @else
                <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($tasks as $task)
                        @php
                            $isLate = $task->deadline->isPast() && $task->status !== 'completed';
                            $daysLeft = now()->diffInDays($task->deadline, false);
                        @endphp
                        <div class="bg-white rounded-2xl border shadow-sm overflow-hidden flex flex-col group
                            @if($task->status==='completed') border-emerald-100 opacity-80
                            @elseif($isLate) border-red-200
                            @else border-gray-100 @endif">

                            {{-- Top color bar --}}
                            <div class="h-1.5
                                @if($task->status==='completed') bg-gradient-to-r from-emerald-400 to-teal-400
                                @elseif($task->status==='progress') bg-gradient-to-r from-blue-400 to-indigo-500
                                @elseif($isLate) bg-gradient-to-r from-red-400 to-rose-400
                                @else bg-gradient-to-r from-amber-400 to-orange-400 @endif">
                            </div>

                            {{-- Card Header --}}
                            <div class="px-5 pt-4 pb-3 border-b border-gray-50 flex items-start justify-between gap-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                                            @if($task->status==='completed') bg-emerald-100 text-emerald-700
                                            @elseif($task->status==='progress') bg-blue-100 text-blue-700
                                            @else bg-amber-100 text-amber-700 @endif">
                                            @if($task->status==='pending')
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Pending
                                            @elseif($task->status==='progress')
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span> Dikerjakan
                                            @else
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Selesai
                                            @endif
                                        </span>
                                        @if($isLate)
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">
                                                ⚠️ Terlambat
                                            </span>
                                        @endif
                                    </div>
                                    <h4 class="font-bold text-gray-800 leading-snug text-base">{{ $task->title }}</h4>
                                </div>
                                {{-- Quick view button --}}
                                <button onclick="openTaskDetail({{ $task->id }})"
                                    class="shrink-0 p-2 text-gray-300 hover:text-indigo-500 hover:bg-indigo-50 rounded-lg transition-colors" title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="px-5 py-3 flex-1">
                                <p class="text-sm text-gray-500 leading-relaxed line-clamp-2">{{ $task->description }}</p>
                            </div>

                            {{-- Meta Info --}}
                            <div class="px-5 py-3 bg-gray-50/60 grid grid-cols-2 gap-3 text-xs">
                                <div class="flex items-center gap-1.5 {{ $isLate ? 'text-red-500 font-semibold' : 'text-gray-400' }}">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $task->deadline->format('d M Y') }}
                                </div>
                                <div class="flex items-center gap-1.5 text-gray-400 justify-end">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    {{ $task->admin->name ?? 'Admin' }}
                                </div>
                                @if($task->status !== 'completed' && !$isLate)
                                    <div class="col-span-2 flex items-center gap-1.5 {{ $daysLeft <= 2 ? 'text-red-400' : 'text-gray-400' }}">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $daysLeft >= 0 ? $daysLeft . ' hari lagi' : 'Sudah lewat' }}
                                        @if($daysLeft <= 2 && $daysLeft >= 0) <span class="text-red-400 font-semibold">— Segera!</span> @endif
                                    </div>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="px-5 py-4">
                                @if($task->status === 'pending')
                                    <button type="button"
                                        onclick="confirmStartTask({{ $task->id }}, '{{ addslashes($task->title) }}')"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        Mulai Kerjakan
                                    </button>
                                @elseif($task->status === 'progress')
                                    <button type="button"
                                        onclick="confirmCompleteTask({{ $task->id }}, '{{ addslashes($task->title) }}')"
                                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Tandai Selesai
                                    </button>
                                @else
                                    <div class="w-full bg-emerald-50 border border-emerald-200 text-emerald-600 text-sm font-semibold py-2.5 rounded-xl flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Tugas Selesai 🎉
                                    </div>
                                @endif
                            </div>

                            {{-- Hidden forms --}}
                            <form id="form-start-{{ $task->id }}" action="{{ route('pegawai.tasks.progress', $task) }}" method="POST" class="hidden">
                                @csrf @method('PUT')
                            </form>
                            <form id="form-complete-{{ $task->id }}" action="{{ route('pegawai.tasks.complete', $task) }}" method="POST" class="hidden">
                                @csrf @method('PUT')
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- ── Task Detail Modal ── --}}
    <div id="task-detail-modal"
         class="modal-backdrop hidden fixed inset-0 z-[9990] bg-black/50 backdrop-blur-sm flex items-center justify-center p-4"
         onclick="if(event.target===this) closeTaskDetail()">
        <div class="modal-box bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
            <div id="modal-status-bar" class="h-2"></div>
            <div class="p-6">
                <div class="flex items-start justify-between gap-3 mb-4">
                    <div>
                        <span id="modal-status-badge" class="px-3 py-1 rounded-full text-xs font-semibold"></span>
                        <h3 id="modal-title" class="text-xl font-extrabold text-gray-800 mt-2"></h3>
                    </div>
                    <button onclick="closeTaskDetail()" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div id="modal-desc" class="bg-gray-50 rounded-xl p-4 text-sm text-gray-600 leading-relaxed mb-4"></div>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 font-medium mb-1">Deadline</p>
                        <p id="modal-deadline" class="font-bold text-gray-800"></p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 font-medium mb-1">Dari Admin</p>
                        <p id="modal-admin" class="font-bold text-gray-800"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $taskData = $tasks->mapWithKeys(fn($t) => [$t->id => [
            'title'    => $t->title,
            'desc'     => $t->description,
            'status'   => $t->status,
            'deadline' => $t->deadline->format('d F Y'),
            'admin'    => $t->admin->name ?? 'Admin',
        ]]);
    @endphp

    <script>
    const TASKS = @json($taskData);

    function openTaskDetail(id) {
        const t = TASKS[id]; if (!t) return;
        const statusConf = {
            pending:   { bar: 'bg-gradient-to-r from-amber-400 to-orange-400',   badge: 'bg-amber-100 text-amber-700',   label: '⏳ Pending' },
            progress:  { bar: 'bg-gradient-to-r from-blue-400 to-indigo-500',    badge: 'bg-blue-100 text-blue-700',     label: '🔄 Dikerjakan' },
            completed: { bar: 'bg-gradient-to-r from-emerald-400 to-teal-400',   badge: 'bg-emerald-100 text-emerald-700', label: '✅ Selesai' },
        };
        const sc = statusConf[t.status] || statusConf.pending;
        document.getElementById('modal-status-bar').className   = `h-2 ${sc.bar}`;
        document.getElementById('modal-status-badge').className = `px-3 py-1 rounded-full text-xs font-semibold ${sc.badge}`;
        document.getElementById('modal-status-badge').textContent = sc.label;
        document.getElementById('modal-title').textContent    = t.title;
        document.getElementById('modal-desc').textContent     = t.desc;
        document.getElementById('modal-deadline').textContent = t.deadline;
        document.getElementById('modal-admin').textContent    = t.admin;
        const modal = document.getElementById('task-detail-modal');
        modal.classList.remove('hidden');
        modal.querySelector('.modal-box').style.animation = 'none';
        requestAnimationFrame(() => { modal.querySelector('.modal-box').style.animation = ''; });
    }

    function closeTaskDetail() {
        document.getElementById('task-detail-modal').classList.add('hidden');
    }

    async function confirmStartTask(id, title) {
        const ok = await showConfirm({
            title: 'Mulai Mengerjakan?',
            message: `Kamu akan memulai tugas "${title}". Pastikan siap mengerjakannya!`,
            okLabel: '🚀 Mulai Sekarang', okClass: 'bg-blue-600 hover:bg-blue-700', icon: 'warning',
        });
        if (ok) document.getElementById(`form-start-${id}`).submit();
    }

    async function confirmCompleteTask(id, title) {
        const ok = await showConfirm({
            title: 'Tandai Selesai?',
            message: `Pastikan tugas "${title}" sudah benar-benar selesai sebelum dikonfirmasi.`,
            okLabel: '✅ Ya, Sudah Selesai', okClass: 'bg-emerald-600 hover:bg-emerald-700', icon: 'success',
        });
        if (ok) document.getElementById(`form-complete-${id}`).submit();
    }
    </script>
</x-app-layout>
