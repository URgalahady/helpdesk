<x-guest-layout>
    {{-- Campus Logo & Title --}}
    <div class="text-center mb-6">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo STMIK Mardira Indonesia" class="w-16 h-16 object-contain mx-auto mb-3">
        <h1 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Helpdesk & Layanan Aspirasi</h1>
        <h2 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">STMIK MARDIRA INDONESIA</h2>
    </div>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Form --}}
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- Username or Email --}}
        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">Nama Pengguna atau Email</label>
            <input id="name" type="text" name="name" 
                   value="{{ old('name') }}" 
                   placeholder="Masukkan username atau email" 
                   class="w-full text-sm rounded-lg border-slate-300 shadow-xs focus:border-[#1b2569] focus:ring-1 focus:ring-[#1b2569] py-2 px-3 text-slate-800 placeholder-slate-400" 
                   required autofocus autocomplete="username">
            @error('name')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-xs font-semibold text-slate-700">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-[#1b2569] hover:underline font-medium">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <input id="password" type="password" name="password" 
                       placeholder="Masukkan password" 
                       class="w-full text-sm rounded-lg border-slate-300 shadow-xs focus:border-[#1b2569] focus:ring-1 focus:ring-[#1b2569] py-2 pl-3 pr-10 text-slate-800 placeholder-slate-400" 
                       required autocomplete="current-password">
                <button type="button" 
                        onclick="togglePassword('password', 'eye-icon')" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-hidden">
                    <svg id="eye-icon" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember me --}}
        <div class="flex items-center pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer text-xs text-slate-600">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-[#1b2569] shadow-xs focus:ring-0">
                <span class="ml-2">Ingat sesi saya</span>
            </label>
        </div>

        {{-- Submit Button --}}
        <button type="submit" 
                class="w-full py-2.5 px-4 bg-[#1b2569] hover:bg-[#151d52] text-white text-sm font-semibold rounded-lg shadow-sm transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-[#1b2569]">
            Masuk ke Sistem
        </button>
    </form>

    {{-- Link to Register --}}
    <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-500">
        Belum memiliki akun? 
        <a href="{{ route('register') }}" class="font-semibold text-[#1b2569] hover:underline">
            Daftar Akun Baru
        </a>
    </div>
</x-guest-layout>
