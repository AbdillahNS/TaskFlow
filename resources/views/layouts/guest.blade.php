<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TaskFlow') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }

            /* Animated gradient background (left panel) */
            .auth-bg {
                background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 40%, #6d28d9 70%, #4338ca 100%);
                background-size: 400% 400%;
                animation: gradientShift 8s ease infinite;
            }
            @keyframes gradientShift {
                0%   { background-position: 0% 50%; }
                50%  { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            /* Floating shapes */
            .shape {
                position: absolute;
                border-radius: 50%;
                background: rgba(255,255,255,0.06);
                animation: float 6s ease-in-out infinite;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50%       { transform: translateY(-20px); }
            }

            /* Input focus ring */
            .auth-input:focus {
                outline: none;
                border-color: #6366f1;
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
            }

            /* Slide-in animation for form panel */
            @keyframes slideInRight {
                from { opacity: 0; transform: translateX(30px); }
                to   { opacity: 1; transform: translateX(0); }
            }
            .form-panel { animation: slideInRight 0.5s ease forwards; }

            /* Feature item dots */
            .feature-dot { background: rgba(255,255,255,0.3); }
        </style>
    </head>
    <body class="antialiased bg-gray-50">
        <div class="min-h-screen flex">

            {{-- ── LEFT PANEL — Branding ── --}}
            <div class="auth-bg hidden lg:flex lg:w-1/2 xl:w-5/12 relative overflow-hidden flex-col justify-between p-12">

                {{-- Decorative shapes --}}
                <div class="shape w-64 h-64 -top-16 -left-16" style="animation-delay:0s"></div>
                <div class="shape w-40 h-40 top-1/3 -right-10" style="animation-delay:2s"></div>
                <div class="shape w-32 h-32 bottom-20 left-1/4" style="animation-delay:4s"></div>
                <div class="shape w-20 h-20 top-1/4 left-1/3" style="animation-delay:1s"></div>
                <div class="shape w-52 h-52 -bottom-20 -right-20" style="animation-delay:3s"></div>

                {{-- Logo --}}
                <div class="relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-extrabold text-white tracking-tight">TaskFlow</span>
                    </div>
                </div>

                {{-- Center content --}}
                <div class="relative z-10">
                    <h1 class="text-4xl xl:text-5xl font-black text-white leading-tight">
                        Kelola Tugas<br>
                        <span class="text-indigo-200">Tim Lebih Mudah</span>
                    </h1>
                    <p class="mt-5 text-indigo-200 text-lg leading-relaxed max-w-sm">
                        Platform manajemen tugas yang membantu admin dan pegawai bekerja lebih produktif dan terorganisir.
                    </p>

                    {{-- Feature list --}}
                    <div class="mt-8 space-y-4">
                        @foreach([
                            ['Assign tugas ke pegawai dengan mudah', '📋'],
                            ['Pantau progress secara real-time', '📊'],
                            ['Notifikasi dan deadline tracking otomatis', '⏰'],
                            ['Dashboard analitik yang informatif', '📈'],
                        ] as [$feat, $icon])
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-white/15 rounded-xl flex items-center justify-center text-base">{{ $icon }}</div>
                            <span class="text-white/85 text-sm font-medium">{{ $feat }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Bottom credits --}}
                <div class="relative z-10">
                    <div class="flex items-center gap-3 text-white/50 text-xs">
                        <div class="flex -space-x-1">
                            @foreach(['A','B','C'] as $i => $l)
                            <div class="w-7 h-7 rounded-full border-2 border-indigo-400 flex items-center justify-center text-xs font-bold text-white"
                                 style="background: hsl({{ 220 + $i * 30 }}, 70%, 55%)">{{ $l }}</div>
                            @endforeach
                        </div>
                        <span>Dipercaya tim produktif di seluruh Indonesia</span>
                    </div>
                </div>
            </div>

            {{-- ── RIGHT PANEL — Form ── --}}
            <div class="form-panel flex-1 flex items-center justify-center p-6 lg:p-12 bg-white">
                <div class="w-full max-w-md">

                    {{-- Mobile logo (shown only on small screens) --}}
                    <div class="flex items-center gap-2 mb-8 lg:hidden">
                        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <span class="text-xl font-extrabold text-gray-900">TaskFlow</span>
                    </div>

                    {{ $slot }}

                </div>
            </div>

        </div>
    </body>
</html>
