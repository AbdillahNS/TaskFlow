<x-guest-layout>
    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900">Selamat datang! 👋</h2>
        <p class="text-gray-400 mt-2 text-sm">Masuk ke akun TaskFlow Anda untuk melanjutkan.</p>
    </div>

    {{-- Demo credentials info --}}
    <div class="mb-6 bg-indigo-50 border border-indigo-100 rounded-2xl p-4">
        <p class="text-xs font-bold text-indigo-700 mb-2 uppercase tracking-wide">🔑 Akun Demo</p>
        <div class="grid grid-cols-2 gap-3 text-xs">
            <div class="bg-white rounded-xl p-3 border border-indigo-100">
                <p class="font-bold text-indigo-600 mb-1">👑 Admin</p>
                <p class="text-gray-500">admin@gmail.com</p>
                <p class="text-gray-400">password</p>
            </div>
            <div class="bg-white rounded-xl p-3 border border-indigo-100">
                <p class="font-bold text-emerald-600 mb-1">👤 Pegawai</p>
                <p class="text-gray-500">pegawai@gmail.com</p>
                <p class="text-gray-400">password</p>
            </div>
        </div>
    </div>

    {{-- Session Status --}}
    @if(session('status'))
        <div class="mb-5 flex items-center gap-2.5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Alamat Email
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </div>
                <input id="email" type="email" name="email"
                    value="{{ old('email') }}"
                    placeholder="nama@email.com"
                    required autofocus autocomplete="username"
                    class="auth-input w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-800 bg-gray-50 placeholder-gray-400 transition-all
                        @error('email') border-red-400 bg-red-50 @enderror">
            </div>
            @error('email')
                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                Password
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input id="password" type="password" name="password"
                    placeholder="Masukkan password"
                    required autocomplete="current-password"
                    class="auth-input w-full pl-11 pr-12 py-3 border border-gray-200 rounded-xl text-sm text-gray-800 bg-gray-50 placeholder-gray-400 transition-all
                        @error('password') border-red-400 bg-red-50 @enderror">
                {{-- Toggle password --}}
                <button type="button" onclick="togglePassword('password', 'eye-icon')"
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                    <svg id="eye-icon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Remember me + Forgot password --}}
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2.5 cursor-pointer group">
                <div class="relative">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="sr-only peer">
                    <div class="w-5 h-5 rounded-md border-2 border-gray-300 peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all flex items-center justify-center">
                        <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 hidden peer-checked:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                <span class="text-sm text-gray-500 group-hover:text-gray-700 transition-colors select-none">Ingat saya</span>
            </label>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                    Lupa password?
                </a>
            @endif
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="w-full bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
            Masuk Sekarang
        </button>

        {{-- Register link --}}
        @if(Route::has('register'))
            <p class="text-center text-sm text-gray-400">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                    Daftar di sini
                </a>
            </p>
        @endif
    </form>

    <script>
    // Checkbox styling fix (Alpine-free)
    document.getElementById('remember_me').addEventListener('change', function() {
        const box = this.nextElementSibling;
        const check = box.querySelector('svg');
        if (this.checked) {
            box.classList.add('bg-indigo-600', 'border-indigo-600');
            check.classList.remove('hidden');
        } else {
            box.classList.remove('bg-indigo-600', 'border-indigo-600');
            check.classList.add('hidden');
        }
    });

    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        document.getElementById(iconId).innerHTML = isPassword
            ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`
            : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    }
    </script>
</x-guest-layout>
