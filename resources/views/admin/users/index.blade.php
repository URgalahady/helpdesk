<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Pengguna — STMIK Mardira Indonesia</title>
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
                <div class="text-[10px] uppercase font-bold text-slate-500 tracking-wider px-3 pt-4 mb-2">Tautan Lainnya</div>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    <span>Portal Mahasiswa / Dosen</span>
                </a>
            </div>
            <div class="p-4 border-t border-slate-800 bg-slate-950">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-white truncate max-w-[120px]">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-slate-400">Administrator</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Keluar" class="p-1.5 rounded text-slate-400 hover:text-rose-400 hover:bg-slate-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="grow flex flex-col min-w-0">
            <header class="h-16 bg-white border-b border-slate-200 px-6 sm:px-8 flex items-center justify-between sticky top-0 z-10 shadow-xs">
                <div class="text-xs font-semibold text-slate-600">Admin Panel / <span class="text-slate-900">Kelola Profil Pengguna</span></div>
                <a href="{{ route('profile.edit') }}" class="font-medium text-xs text-slate-600 hover:text-blue-600">Profil Saya</a>
            </header>

            <main class="p-6 sm:p-8 space-y-6">
                @if(session('success'))
                    <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between text-sm">
                        <span>{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Kelola Profil Pengguna</h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Atur data profil akademik/pengajar mahasiswa dan dosen. Data ini ditampilkan di dashboard masing-masing.</p>
                    </div>
                    <div class="flex gap-2 text-xs">
                        <span class="px-3 py-1.5 rounded-md bg-blue-50 text-blue-700 border border-blue-200 font-semibold">Mahasiswa: {{ $stats['mahasiswa'] }}</span>
                        <span class="px-3 py-1.5 rounded-md bg-indigo-50 text-indigo-700 border border-indigo-200 font-semibold">Dosen: {{ $stats['dosen'] }}</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
                    <div class="p-4 border-b border-slate-100 bg-slate-50">
                        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row gap-2 text-xs">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, NIM/NIDN..." class="grow rounded-md border-slate-300 focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                            <select name="role" class="rounded-md border-slate-300 focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                                <option value="">Semua role</option>
                                <option value="mahasiswa" @selected(request('role')==='mahasiswa')>Mahasiswa</option>
                                <option value="dosen" @selected(request('role')==='dosen')>Dosen</option>
                            </select>
                            <button type="submit" class="px-4 py-2 rounded-md bg-[#1b2569] text-white font-semibold">Filter</button>
                            @if(request()->hasAny(['q','role']))
                                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-md bg-white border border-slate-300 text-slate-700 font-semibold text-center">Reset</a>
                            @endif
                        </form>
                    </div>

                    @if($users->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                                <thead class="bg-slate-50 text-slate-500 uppercase font-bold tracking-wider">
                                    <tr>
                                        <th class="px-5 py-3.5">Pengguna</th>
                                        <th class="px-5 py-3.5">Role</th>
                                        <th class="px-5 py-3.5">Identitas (NIM/NIDN)</th>
                                        <th class="px-5 py-3.5">Program Studi / Jurusan</th>
                                        <th class="px-5 py-3.5">Info Tambahan</th>
                                        <th class="px-5 py-3.5 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($users as $u)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-5 py-3.5">
                                                <div class="font-bold text-slate-900">{{ $u->name }}</div>
                                                <div class="text-slate-500">{{ $u->email }}</div>
                                            </td>
                                            <td class="px-5 py-3.5 whitespace-nowrap">
                                                <span class="px-2 py-0.5 rounded text-[11px] font-semibold border {{ $u->role === 'dosen' ? 'bg-indigo-50 text-indigo-800 border-indigo-200' : 'bg-blue-50 text-blue-800 border-blue-200' }}">
                                                    {{ ucfirst($u->role) }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-3.5 whitespace-nowrap text-slate-700">{{ $u->role === 'dosen' ? ($u->nidn_nip ?: '—') : ($u->nim ?: '—') }}</td>
                                            <td class="px-5 py-3.5 text-slate-700">{{ $u->program_studi ?: ($u->jurusan ?: '—') }}</td>
                                            <td class="px-5 py-3.5 text-slate-700">
                                                @if($u->role === 'mahasiswa')
                                                    Semester: {{ $u->semester ?: '—' }}
                                                @else
                                                    {{ $u->status_pengajar ?: '—' }}
                                                @endif
                                            </td>
                                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                                <a href="{{ route('admin.users.edit', $u) }}" class="inline-flex items-center px-3 py-1.5 rounded-md bg-blue-50 text-blue-700 hover:bg-blue-100 font-semibold">Atur Profil</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 border-t border-slate-100 bg-slate-50">{{ $users->links() }}</div>
                    @else
                        <div class="py-12 px-4 text-center text-slate-400 text-sm">Tidak ada pengguna ditemukan.</div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</body>
</html>
