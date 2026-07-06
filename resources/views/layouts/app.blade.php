<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TaskFlow') }} - @yield('title', 'Dashboard')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }

            /* Toast animations */
            @keyframes slideInRight {
                from { transform: translateX(110%); opacity: 0; }
                to   { transform: translateX(0);    opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0);    opacity: 1; }
                to   { transform: translateX(110%); opacity: 0; }
            }
            .toast-enter  { animation: slideInRight 0.35s ease forwards; }
            .toast-leave  { animation: slideOutRight 0.35s ease forwards; }

            /* Modal animations */
            @keyframes fadeIn  { from { opacity: 0; } to { opacity: 1; } }
            @keyframes scaleIn { from { opacity: 0; transform: scale(0.92) translateY(-8px); } to { opacity: 1; transform: scale(1) translateY(0); } }
            .modal-backdrop { animation: fadeIn  0.2s ease forwards; }
            .modal-box      { animation: scaleIn 0.25s ease forwards; }

            /* Sidebar gradient line */
            .nav-gradient { background: linear-gradient(135deg, #6366f1, #8b5cf6); }

            /* Card hover lift */
            .card-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
            .card-lift:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.10); }

            /* Progress bar animation */
            @keyframes growBar { from { width: 0%; } to { width: var(--bar-width); } }
            .animated-bar { animation: growBar 0.8s ease-out forwards; }

            /* Pulse dot */
            .pulse-dot::before {
                content: '';
                display: inline-block;
                width: 8px; height: 8px;
                border-radius: 50%;
                background: currentColor;
                animation: pulse 1.8s infinite;
                margin-right: 6px;
            }
            @keyframes pulse {
                0%, 100% { opacity: 1; transform: scale(1); }
                50%       { opacity: 0.5; transform: scale(1.3); }
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">

        <!-- ───── TOAST CONTAINER ───── -->
        <div id="toast-container"
             class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 pointer-events-none"
             style="min-width:320px; max-width:420px;">
        </div>

        <!-- ───── GLOBAL CONFIRM MODAL ───── -->
        <div id="confirm-modal"
             class="modal-backdrop hidden fixed inset-0 z-[9998] bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="modal-box bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">
                <div id="confirm-icon-wrap" class="flex justify-center pt-7 pb-2">
                    <!-- icon injected by JS -->
                </div>
                <div class="px-7 pb-3 text-center">
                    <h3 id="confirm-title"  class="text-lg font-bold text-gray-800 mt-2"></h3>
                    <p  id="confirm-message" class="text-sm text-gray-500 mt-1.5 leading-relaxed"></p>
                </div>
                <div class="flex gap-3 px-7 pb-7 pt-4">
                    <button id="confirm-cancel"
                        class="flex-1 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold text-sm hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button id="confirm-ok"
                        class="flex-1 py-2.5 rounded-xl text-white font-semibold text-sm transition-colors">
                        Konfirmasi
                    </button>
                </div>
            </div>
        </div>

        <div class="min-h-screen bg-gray-50">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white border-b border-gray-100 shadow-sm">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- ───── TOAST + MODAL JS ───── -->
        <script>
        // ── Toast System ──────────────────────────────────────────────
        function showToast(message, type = 'success', duration = 4000) {
            const icons = {
                success: `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
                error:   `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
                warning: `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`,
                info:    `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            };
            const colors = {
                success: 'bg-emerald-500', error: 'bg-red-500',
                warning: 'bg-amber-500',   info: 'bg-blue-500',
            };
            const container = document.getElementById('toast-container');

            const toast = document.createElement('div');
            toast.className = `toast-enter pointer-events-auto flex items-start gap-3 ${colors[type]} text-white px-5 py-4 rounded-2xl shadow-xl`;
            toast.innerHTML = `
                <div class="shrink-0 mt-0.5">${icons[type]}</div>
                <p class="text-sm font-medium leading-snug flex-1">${message}</p>
                <button onclick="dismissToast(this.parentElement)" class="shrink-0 mt-0.5 opacity-70 hover:opacity-100 transition-opacity">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>`;

            container.appendChild(toast);

            // Progress bar
            const bar = document.createElement('div');
            bar.className = 'absolute bottom-0 left-0 h-1 rounded-b-2xl bg-white/30';
            bar.style.cssText = `width:100%; transition: width ${duration}ms linear;`;
            toast.style.position = 'relative';
            toast.style.overflow = 'hidden';
            toast.appendChild(bar);
            requestAnimationFrame(() => { bar.style.width = '0%'; });

            const timer = setTimeout(() => dismissToast(toast), duration);
            toast._timer = timer;
        }

        function dismissToast(toast) {
            if (!toast || !toast.parentElement) return;
            clearTimeout(toast._timer);
            toast.className = toast.className.replace('toast-enter', 'toast-leave');
            setTimeout(() => toast.remove(), 350);
        }

        // ── Confirm Modal ─────────────────────────────────────────────
        let _resolveConfirm = null;

        function showConfirm({ title, message, okLabel = 'Konfirmasi', okClass = 'bg-red-500 hover:bg-red-600', icon = 'danger' }) {
            return new Promise(resolve => {
                _resolveConfirm = resolve;
                const icons = {
                    danger:  { bg: 'bg-red-100',    svg: `<svg class="w-10 h-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>` },
                    warning: { bg: 'bg-amber-100',  svg: `<svg class="w-10 h-10 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>` },
                    success: { bg: 'bg-green-100',  svg: `<svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>` },
                };
                const ic = icons[icon] || icons.danger;
                document.getElementById('confirm-icon-wrap').innerHTML =
                    `<div class="w-20 h-20 rounded-full ${ic.bg} flex items-center justify-center">${ic.svg}</div>`;
                document.getElementById('confirm-title').textContent   = title;
                document.getElementById('confirm-message').textContent = message;

                const okBtn = document.getElementById('confirm-ok');
                okBtn.textContent  = okLabel;
                okBtn.className = `flex-1 py-2.5 rounded-xl text-white font-semibold text-sm transition-colors ${okClass}`;

                const modal = document.getElementById('confirm-modal');
                modal.classList.remove('hidden');
                modal.querySelector('.modal-box').style.animation = 'none';
                requestAnimationFrame(() => {
                    modal.querySelector('.modal-box').style.animation = '';
                });
            });
        }

        document.getElementById('confirm-ok').addEventListener('click', () => {
            document.getElementById('confirm-modal').classList.add('hidden');
            if (_resolveConfirm) _resolveConfirm(true);
        });
        document.getElementById('confirm-cancel').addEventListener('click', () => {
            document.getElementById('confirm-modal').classList.add('hidden');
            if (_resolveConfirm) _resolveConfirm(false);
        });
        document.getElementById('confirm-modal').addEventListener('click', (e) => {
            if (e.target === e.currentTarget) {
                e.currentTarget.classList.add('hidden');
                if (_resolveConfirm) _resolveConfirm(false);
            }
        });

        // ── Handle server-side flash messages as toast ────────────────
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', () => showToast(@json(session('success')), 'success'));
        @endif
        @if(session('error'))
            document.addEventListener('DOMContentLoaded', () => showToast(@json(session('error')), 'error'));
        @endif
        @if(session('warning'))
            document.addEventListener('DOMContentLoaded', () => showToast(@json(session('warning')), 'warning'));
        @endif
        </script>
    </body>
</html>
