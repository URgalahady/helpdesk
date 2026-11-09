<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Profil Pengguna — STMIK Mardira Indonesia</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-100 font-sans text-slate-800 antialiased">
    <div class="min-h-full flex flex-col md:flex-row">
        <aside class="w-full md:w-64 bg-slate-900 text-slate-300 shrink-0 flex flex-col border-r border-slate-800 z-20">
            <div class="h-16 flex items-center gap-3 px-5 border-b border-slate-800 bg-slate-950">
                <div class="w-8 h-8 rounded-full bg-white p-0.5 flex items-center justify-center shrink-0">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-full h-full object-contain rounded-full">
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-bold uppercase tracking-wider text-white">ADMIN PANEL</span>
                    <span class="text-[10px] text-slate-400 font-medium">STMIK MARDIRA INDONESIA</span>
                </div>
            </div>
            <div class="p-4 space-y-1 grow text-xs font-medium">
                <div class="text-[10px] uppercase font-bold text-slate-500 tracking-wider px-3 mb-2">Menu Utama</div>
                <a href="{{ route('dashboard.admin') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    <span>Dashboard &amp; Overview</span>
                </a>
                <a href="{{ route('tickets.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    <span>Kelola Pengaduan</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg bg-blue-600 text-white font-semibold shadow-xs">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <span>Kelola Pengguna</span>
                </a>
            </div>
            <div class="p-4 border-t border-slate-800 bg-slate-950">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-white truncate max-w-[120px]">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-slate-400">Administrator</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" title="Keluar" class="p-1.5 rounded text-slate-400 hover:text-rose-400 hover:bg-slate-800 transition-colors"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg></button></form>
                </div>
            </div>
        </aside>

        <div class="grow flex flex-col min-w-0">
            <header class="h-16 bg-white border-b border-slate-200 px-6 sm:px-8 flex items-center justify-between sticky top-0 z-10 shadow-xs">
                <div class="text-xs font-semibold text-slate-600">
                    <a href="{{ route('admin.users.index') }}" class="text-[#1b2569] hover:underline">Kelola Pengguna</a> / <span class="text-slate-900">Edit Profil</span>
                </div>
            </header>

            <main class="p-6 sm:p-8">
                <div class="max-w-3xl space-y-6">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Atur Profil: {{ $user->name }}</h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Role: <span class="font-semibold capitalize">{{ $user->role }}</span> · {{ $user->email }}. Hanya admin yang dapat mengubah data profil ini.</p>
                    </div>

                    @if ($errors->any())
                        <div class="p-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-sm">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white rounded-xl border border-slate-200 shadow-xs p-6 space-y-5">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <h2 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2">Data Akun</h2>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-md border-slate-300 text-sm focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-md border-slate-300 text-sm focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            <div class="sm:col-span-2">
                                <h2 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2">Data Profil {{ $user->role === 'dosen' ? 'Dosen' : ($user->role === 'mahasiswa' ? 'Mahasiswa' : 'Pengguna') }}</h2>
                                <p class="text-[11px] text-slate-500 mt-1">Isi sesuai peran pengguna. Kosongkan jika belum tersedia.</p>
                            </div>

                            @if($user->role !== 'dosen')
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">NIM (Mahasiswa)</label>
                                <input type="text" name="nim" value="{{ old('nim', $user->nim) }}" placeholder="Contoh: 24110001" class="w-full rounded-md border-slate-300 text-sm focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                            </div>
                            @endif

                            @if($user->role !== 'mahasiswa')
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">NIDN / NIP (Dosen)</label>
                                <input type="text" name="nidn_nip" value="{{ old('nidn_nip', $user->nidn_nip) }}" placeholder="Contoh: 04120001" class="w-full rounded-md border-slate-300 text-sm focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                            </div>
                            @endif

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Jurusan</label>
                                <input type="text" name="jurusan" value="{{ old('jurusan', $user->jurusan) }}" placeholder="Contoh: Teknik Informatika" class="w-full rounded-md border-slate-300 text-sm focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Program Studi</label>
                                <input type="text" name="program_studi" value="{{ old('program_studi', $user->program_studi) }}" placeholder="Contoh: Teknik Informatika" class="w-full rounded-md border-slate-300 text-sm focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                            </div>

                            @if($user->role !== 'dosen')
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Semester (Mahasiswa)</label>
                                <input type="text" name="semester" value="{{ old('semester', $user->semester) }}" placeholder="Contoh: 5" class="w-full rounded-md border-slate-300 text-sm focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                            </div>
                            @endif

                            @if($user->role !== 'mahasiswa')
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Status Pengajar (Dosen)</label>
                                <input type="text" name="status_pengajar" value="{{ old('status_pengajar', $user->status_pengajar) }}" placeholder="Contoh: Dosen Tetap" class="w-full rounded-md border-slate-300 text-sm focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                            </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-md border border-slate-300 bg-white text-slate-700 text-sm font-semibold hover:bg-slate-50">Batal</a>
                            <button type="submit" class="px-4 py-2 rounded-md bg-[#1b2569] hover:bg-[#151d52] text-white text-sm font-semibold">Simpan Profil</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
