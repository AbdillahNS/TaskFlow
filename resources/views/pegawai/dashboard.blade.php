<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800">👤 Dashboard Saya</h2>
                <p class="text-sm text-gray-400 mt-0.5">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-7">

            {{-- ── Greeting Banner ── --}}
            <div class="relative bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-600 rounded-3xl p-7 text-white shadow-xl overflow-hidden">
                <div class="absolute -top-10 -right-10 w-48 h-48 rounded-full bg-white/5"></div>
                <div class="absolute top-8 right-8 w-24 h-24 rounded-full bg-white/10"></div>
                <div class="flex items-center justify-between relative">
                    <div>
                        <h3 class="text-2xl font-extrabold">Halo, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-emerald-100 mt-1.5 text-sm">
                            @if($stats['pending'] > 0 || $stats['progress'] > 0)
                                Kamu punya <strong class="text-white">{{ $stats['pending'] + $stats['progress'] }} tugas</strong> yang perlu diselesaikan.
                            @elseif($stats['total'] > 0)
                                Luar biasa! Semua tugasmu sudah selesai! 🎉
                            @else
                                Selamat datang! Belum ada tugas untukmu hari ini.
                            @endif
                        </p>
                    </div>
                    <a href="{{ route('pegawai.tasks.index') }}"
                        class="hidden md:inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-semibold px-5 py-2.5 rounded-xl transition-all text-sm border border-white/20">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        Lihat Tugasku
                    </a>
                </div>
            </div>

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
                </div>
                @endforeach
            </div>

            @if($stats['total'] > 0)
            {{-- ── Progress & Quick Actions ── --}}
            <div class="grid lg:grid-cols-3 gap-6">

                {{-- Progress Donut --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center gap-4">
                    <h3 class="font-bold text-gray-800 self-start w-full">Progress Tugasku</h3>
                    @php
                        $pct = round(($stats['completed'] / $stats['total']) * 100);
                        $circumference = 2 * 3.14159 * 54;
                        $offset = $circumference - ($pct / 100) * $circumference;
                    @endphp
                    <div class="relative w-40 h-40">
                        <svg class="w-40 h-40 -rotate-90" viewBox="0 0 120 120">
                            <circle cx="60" cy="60" r="54" fill="none" stroke="#f3f4f6" stroke-width="10"/>
                            <circle cx="60" cy="60" r="54" fill="none"
                                stroke="url(#grad-emp)" stroke-width="10"
                                stroke-linecap="round"
                                stroke-dasharray="{{ $circumference }}"
                                stroke-dashoffset="{{ $offset }}"/>
                            <defs>
                                <linearGradient id="grad-emp" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%"   stop-color="#10b981"/>
                                    <stop offset="100%" stop-color="#06b6d4"/>
                                </linearGradient>
                            </defs>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-3xl font-extrabold text-gray-800">{{ $pct }}%</span>
                            <span class="text-xs text-gray-400 font-medium">Selesai</span>
                        </div>
                    </div>
                    <div class="w-full space-y-2">
                        @foreach([['Pending','amber',$stats['pending']],['Progress','blue',$stats['progress']],['Selesai','emerald',$stats['completed']]] as [$lbl,$clr,$val])
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-{{ $clr }}-400 shrink-0"></span>
                            <span class="text-xs text-gray-500 w-16">{{ $lbl }}</span>
                            <div class="flex-1 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-{{ $clr }}-400 h-1.5 rounded-full" style="width: {{ ($val / $stats['total']) * 100 }}%"></div>
                            </div>
                            <span class="text-xs font-bold text-gray-700 w-5 text-right">{{ $val }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Motivasi + CTA --}}
                <div class="lg:col-span-2 space-y-4">
                    {{-- Motivasi card --}}
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-100 rounded-2xl p-6">
                        <p class="text-indigo-500 font-semibold text-xs uppercase tracking-wide mb-2">💡 Motivasi Hari Ini</p>
                        @php
                            $quotes = [
                                'Selesaikan satu tugas hari ini, buat hidupmu lebih baik esok hari.',
                                'Produktivitas bukan tentang banyak tugas, tapi tentang tugas yang tepat.',
                                'Langkah kecil setiap hari membawa perubahan besar.',
                                'Kerjakan dengan sepenuh hati, hasilnya akan luar biasa!',
                                'Fokus pada apa yang bisa kamu kendalikan — pekerjaan hari ini.',
                            ];
                            $quote = $quotes[date('N') % count($quotes)];
                        @endphp
                        <p class="text-gray-700 italic text-sm leading-relaxed">"{{ $quote }}"</p>
                    </div>

                    {{-- Quick action --}}
                    <a href="{{ route('pegawai.tasks.index') }}"
                        class="flex items-center justify-between bg-emerald-600 hover:bg-emerald-700 transition-colors text-white rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="bg-emerald-500 rounded-xl p-3">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                            </div>
                            <div>
                                <p class="font-bold text-lg">Kelola Semua Tugasku</p>
                                <p class="text-emerald-200 text-sm">{{ $stats['pending'] + $stats['progress'] }} tugas perlu perhatian</p>
                            </div>
                        </div>
                        <svg class="w-6 h-6 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    {{-- Achievement --}}
                    @if($stats['completed'] > 0)
                    <div class="bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-100 rounded-2xl p-5 flex items-center gap-4">
                        <div class="text-4xl">🏆</div>
                        <div>
                            <p class="font-bold text-amber-800">Pencapaian!</p>
                            <p class="text-sm text-amber-600">Kamu sudah menyelesaikan <strong>{{ $stats['completed'] }} tugas</strong>. Terus semangat!</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm text-center py-16">
                <div class="text-5xl mb-4">📭</div>
                <p class="text-lg font-semibold text-gray-600">Belum ada tugas untukmu</p>
                <p class="text-sm text-gray-400 mt-1">Admin akan memberikan tugas kepadamu segera.</p>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
