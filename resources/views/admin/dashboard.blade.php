<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">👑 Dashboard Admin</h2>
                <p class="text-sm text-gray-400 mt-0.5">Pantau semua aktivitas tugas tim Anda</p>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500 bg-gray-50 border border-gray-200 rounded-xl px-4 py-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ now()->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-7">

            {{-- ── Greeting Banner ── --}}
            <div class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-violet-700 rounded-3xl p-7 text-white shadow-xl overflow-hidden">
                {{-- decorative circles --}}
                <div class="absolute -top-10 -right-10 w-48 h-48 rounded-full bg-white/5"></div>
                <div class="absolute top-10 -right-5 w-28 h-28 rounded-full bg-white/5"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-extrabold">Selamat datang, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-indigo-200 mt-1.5 text-sm">
                            @if($stats['pending'] > 0)
                                Ada <strong class="text-white">{{ $stats['pending'] }} tugas</strong> yang masih menunggu dikerjakan.
                            @else
                                Semua tugas sedang berjalan dengan baik! 🎉
                            @endif
                        </p>
                    </div>
                    <div class="hidden md:flex gap-3">
                        <a href="{{ route('admin.tasks.create') }}"
                            class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-semibold px-5 py-2.5 rounded-xl transition-all text-sm border border-white/20">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Buat Tugas
                        </a>
                        <a href="{{ route('admin.users.create') }}"
                            class="inline-flex items-center gap-2 bg-white text-indigo-700 hover:bg-indigo-50 font-semibold px-5 py-2.5 rounded-xl transition-all text-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Tambah Pegawai
                        </a>
                    </div>
                </div>
            </div>

            {{-- ── Stat Cards ── --}}
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                @php
                    $statCards = [
                        ['label'=>'Total Tugas',  'val'=>$stats['total'],     'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'bg'=>'bg-indigo-50',  'icon_color'=>'text-indigo-600', 'num_color'=>'text-indigo-700'],
                        ['label'=>'Pending',       'val'=>$stats['pending'],   'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',   'bg'=>'bg-amber-50',   'icon_color'=>'text-amber-500',  'num_color'=>'text-amber-600'],
                        ['label'=>'In Progress',   'val'=>$stats['progress'],  'icon'=>'M13 10V3L4 14h7v7l9-11h-7z',                      'bg'=>'bg-blue-50',    'icon_color'=>'text-blue-500',   'num_color'=>'text-blue-600'],
                        ['label'=>'Selesai',       'val'=>$stats['completed'], 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',   'bg'=>'bg-emerald-50', 'icon_color'=>'text-emerald-600','num_color'=>'text-emerald-700'],
                        ['label'=>'Pegawai',       'val'=>$stats['pegawai'],   'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'bg'=>'bg-purple-50', 'icon_color'=>'text-purple-600', 'num_color'=>'text-purple-700'],
                    ];
                @endphp
                @foreach($statCards as $card)
                <div class="card-lift bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ $card['label'] }}</p>
                            <p class="text-3xl font-extrabold {{ $card['num_color'] }} mt-2">{{ $card['val'] }}</p>
                        </div>
                        <div class="{{ $card['bg'] }} p-3 rounded-xl">
                            <svg class="w-6 h-6 {{ $card['icon_color'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                            </svg>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- ── Progress Overview + Recent Tasks ── --}}
            <div class="grid lg:grid-cols-3 gap-6">

                {{-- Progress Ring --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center justify-center gap-4">
                    <h3 class="font-bold text-gray-800 self-start w-full">Progres Keseluruhan</h3>
                    @php
                        $pct = $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0;
                        $circumference = 2 * 3.14159 * 54;
                        $offset = $circumference - ($pct / 100) * $circumference;
                    @endphp
                    <div class="relative w-40 h-40">
                        <svg class="w-40 h-40 -rotate-90" viewBox="0 0 120 120">
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#f3f4f6" stroke-width="10"/>
                            <circle cx="60" cy="60" r="54" fill="none"
                                stroke="url(#grad)" stroke-width="10"
                                stroke-linecap="round"
                                stroke-dasharray="{{ $circumference }}"
                                stroke-dashoffset="{{ $offset }}"
                                style="transition: stroke-dashoffset 1s ease;"/>
                            <defs>
                                <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%"   stop-color="#6366f1"/>
                                    <stop offset="100%" stop-color="#8b5cf6"/>
                                </linearGradient>
                            </defs>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-3xl font-extrabold text-gray-800">{{ $pct }}%</span>
                            <span class="text-xs text-gray-400 font-medium">Selesai</span>
                        </div>
                    </div>
                    <div class="w-full space-y-2.5">
                        @php $statBars = [['Pending','pending','bg-amber-400',$stats['pending']],['Progress','progress','bg-blue-400',$stats['progress']],['Selesai','completed','bg-emerald-400',$stats['completed']]]; @endphp
                        @foreach($statBars as [$lbl,,$barColor,$val])
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full {{ $barColor }} shrink-0"></span>
                                <span class="text-xs text-gray-500 w-16">{{ $lbl }}</span>
                                <div class="flex-1 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                    @php $bPct = $stats['total'] > 0 ? ($val / $stats['total']) * 100 : 0; @endphp
                                    <div class="{{ $barColor }} h-1.5 rounded-full" style="width: {{ $bPct }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-700 w-6 text-right">{{ $val }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Recent Tasks ── (takes 2 cols) --}}
                <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                        <h3 class="font-bold text-gray-800">Tugas Terbaru</h3>
                        <a href="{{ route('admin.tasks.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors">
                            Lihat Semua →
                        </a>
                    </div>
                    @if($recentTasks->isEmpty())
                        <div class="text-center py-14 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                            <p class="font-medium">Belum ada tugas.</p>
                        </div>
                    @else
                        <div class="divide-y divide-gray-50">
                            @foreach($recentTasks as $task)
                                <div class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50/80 transition-colors group">
                                    {{-- avatar --}}
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-sm">
                                        {{ strtoupper(substr($task->employee->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-800 truncate">{{ $task->title }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            → {{ $task->employee->name ?? '-' }}
                                            &nbsp;·&nbsp;
                                            <span class="{{ $task->deadline->isPast() && $task->status !== 'completed' ? 'text-red-500' : '' }}">
                                                {{ $task->deadline->format('d M Y') }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                            @if($task->status==='completed') bg-emerald-100 text-emerald-700
                                            @elseif($task->status==='progress') bg-blue-100 text-blue-700
                                            @else bg-amber-100 text-amber-700 @endif">
                                            @if($task->status==='pending') Pending
                                            @elseif($task->status==='progress') Progress
                                            @else Selesai @endif
                                        </span>
                                        <a href="{{ route('admin.tasks.show', $task) }}"
                                            class="opacity-0 group-hover:opacity-100 transition-opacity p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
