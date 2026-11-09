<x-guest-layout>
    {{-- Campus Logo & Title --}}
    <div class="text-center mb-6">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo STMIK Mardira Indonesia" class="w-16 h-16 object-contain mx-auto mb-3">
        <h1 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pendaftaran Akun Baru</h1>
        <h2 class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">STMIK MARDIRA INDONESIA</h2>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Nama Lengkap --}}
        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
            <input id="name" type="text" name="name" 
                   value="{{ old('name') }}" 
                   placeholder="Contoh: Muhammad Raihan" 
                   class="w-full text-sm rounded-lg border-slate-300 shadow-xs focus:border-[#1b2569] focus:ring-1 focus:ring-[#1b2569] py-2 px-3 text-slate-800 placeholder-slate-400" 
                   required autofocus autocomplete="name">
            @error('name')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email</label>
            <input id="email" type="email" name="email" 
                   value="{{ old('email') }}" 
                   placeholder="nama@stmik-mi.ac.id atau email aktif" 
                   class="w-full text-sm rounded-lg border-slate-300 shadow-xs focus:border-[#1b2569] focus:ring-1 focus:ring-[#1b2569] py-2 px-3 text-slate-800 placeholder-slate-400" 
                   required autocomplete="username">
            @error('email')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Role Selector --}}
        <div>
            <label for="role" class="block text-xs font-semibold text-slate-700 mb-1">Daftar Sebagai (Peran)</label>
            <select id="role" name="role" 
                    class="w-full text-sm rounded-lg border-slate-300 shadow-xs focus:border-[#1b2569] focus:ring-1 focus:ring-[#1b2569] py-2 px-3 text-slate-800 bg-white" required>
                <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen / Pengajar</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Staf / Administrator</option>
            </select>
            @error('role')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
            <div class="relative">
                <input id="password" type="password" name="password" 
                       placeholder="Minimal 8 karakter" 
                       class="w-full text-sm rounded-lg border-slate-300 shadow-xs focus:border-[#1b2569] focus:ring-1 focus:ring-[#1b2569] py-2 pl-3 pr-10 text-slate-800 placeholder-slate-400" 
                       required autocomplete="new-password">
                <button type="button" 
                        onclick="togglePassword('password', 'eye-reg')" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-hidden">
                    <svg id="eye-reg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Password</label>
            <div class="relative">
                <input id="password_confirmation" type="password" name="password_confirmation" 
                       placeholder="Ulangi password" 
                       class="w-full text-sm rounded-lg border-slate-300 shadow-xs focus:border-[#1b2569] focus:ring-1 focus:ring-[#1b2569] py-2 pl-3 pr-10 text-slate-800 placeholder-slate-400" 
                       required autocomplete="new-password">
                <button type="button" 
                        onclick="togglePassword('password_confirmation', 'eye-conf')" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-hidden">
                    <svg id="eye-conf" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password_confirmation')
                <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <button type="submit" 
                class="w-full py-2.5 px-4 bg-[#1b2569] hover:bg-[#151d52] text-white text-sm font-semibold rounded-lg shadow-sm transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-[#1b2569] mt-2">
            Daftar Akun
        </button>
    </form>

    {{-- Link to Login --}}
    <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-500">
        Sudah memiliki akun? 
        <a href="{{ route('login') }}" class="font-semibold text-[#1b2569] hover:underline">
            Masuk di sini
        </a>
    </div>
</x-guest-layout>
