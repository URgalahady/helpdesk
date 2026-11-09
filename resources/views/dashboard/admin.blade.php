<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel — STMIK Mardira Indonesia</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-100 font-sans text-slate-800 antialiased" x-data="{ sidebarOpen: false, activeTab: 'all' }">

    <div class="min-h-full flex flex-col md:flex-row">
        
        {{-- ==================== SIDEBAR ==================== --}}
        <aside class="w-full md:w-64 bg-slate-900 text-slate-300 shrink-0 flex flex-col border-r border-slate-800 z-20">
            
            {{-- Brand / Logo --}}
            <div class="h-16 flex items-center gap-3 px-5 border-b border-slate-800 bg-slate-950">
                <div class="w-8 h-8 rounded-full bg-white p-0.5 flex items-center justify-center shrink-0">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-full h-full object-contain rounded-full">
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-bold uppercase tracking-wider text-white">ADMIN PANEL</span>
                    <span class="text-[10px] text-slate-400 font-medium">STMIK MARDIRA INDONESIA</span>
                </div>
            </div>

            {{-- Navigation Menu --}}
            <div class="p-4 space-y-1 grow text-xs font-medium">
                <div class="text-[10px] uppercase font-bold text-slate-500 tracking-wider px-3 mb-2">Menu Utama</div>

                <a href="{{ route('dashboard.admin') }}" 
                   class="flex items-center justify-between px-3 py-2.5 rounded-lg bg-blue-600 text-white font-semibold shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard & Overview</span>
                    </div>
                </a>

                <a href="{{ route('tickets.index') }}" 
                   class="flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span>Kelola Pengaduan</span>
                    </div>
                    @if(($stats['pending'] ?? 0) > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-slate-950">
                            {{ $stats['pending'] }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Kelola Pengguna</span>
                </a>

                <div class="text-[10px] uppercase font-bold text-slate-500 tracking-wider px-3 pt-4 mb-2">Tautan Lainnya</div>

                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Portal Mahasiswa / Dosen</span>
                </a>

                <a href="/" 
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    <span>Halaman Utama (Welcome)</span>
                </a>
            </div>

            {{-- Sidebar Footer --}}
            <div class="p-4 border-t border-slate-800 bg-slate-950">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-white truncate max-w-[120px]">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-slate-400">Administrator</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Keluar" class="p-1.5 rounded text-slate-400 hover:text-rose-400 hover:bg-slate-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        {{-- ==================== MAIN CONTENT ==================== --}}
        <div class="grow flex flex-col min-w-0">
            
            {{-- Topbar --}}
            <header class="h-16 bg-white border-b border-slate-200 px-6 sm:px-8 flex items-center justify-between sticky top-0 z-10 shadow-xs">
                <div class="text-xs font-semibold text-slate-600">
                    Admin Panel / <span class="text-slate-900">Pusat Pengelolaan Pengaduan</span>
                </div>

                <div class="flex items-center gap-4 text-xs">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-medium">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Sistem Aktif</span>
                    </span>
                    <a href="{{ route('profile.edit') }}" class="font-medium text-slate-600 hover:text-blue-600">
                        Profil Saya
                    </a>
                </div>
            </header>

            {{-- Main Content --}}
            <main class="p-6 sm:p-8 space-y-6">

                {{-- Flash Message --}}
                @if(session('success'))
                    <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
                    </div>
                @endif

                {{-- Page Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-slate-900">Dashboard Pengelolaan Helpdesk</h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola dan perbarui status tindak lanjut pengaduan dari seluruh civitas akademika.</p>
                    </div>
                    <a href="{{ route('tickets.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#1b2569] hover:bg-[#151d52] text-white text-xs font-semibold shadow-xs transition-colors self-start sm:self-auto">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        <span>Tabel Seluruh Pengaduan</span>
                    </a>
                </div>

                {{-- 4 Metric Cards (Clean, standard enterprise style) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    {{-- Pending --}}
                    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-xs border-l-4 border-l-amber-500">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500 uppercase">Menunggu Review</span>
                            <span class="text-amber-500 font-bold text-xs bg-amber-50 px-2 py-0.5 rounded">Pending</span>
                        </div>
                        <div class="text-2xl sm:text-3xl font-bold text-slate-900 mt-2">{{ $stats['pending'] ?? 0 }}</div>
                        <div class="text-[11px] text-slate-500 mt-1">Laporan perlu ditindaklanjuti</div>
                    </div>

                    {{-- Accepted --}}
                    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-xs border-l-4 border-l-blue-600">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500 uppercase">Diterima Admin</span>
                            <span class="text-blue-600 font-bold text-xs bg-blue-50 px-2 py-0.5 rounded">Accepted</span>
                        </div>
                        <div class="text-2xl sm:text-3xl font-bold text-slate-900 mt-2">{{ $stats['accepted'] ?? 0 }}</div>
                        <div class="text-[11px] text-slate-500 mt-1">Telah disetujui untuk perbaikan</div>
                    </div>

                    {{-- Implemented --}}
                    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-xs border-l-4 border-l-purple-600">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500 uppercase">Sedang Diterapkan</span>
                            <span class="text-purple-600 font-bold text-xs bg-purple-50 px-2 py-0.5 rounded">Process</span>
                        </div>
                        <div class="text-2xl sm:text-3xl font-bold text-slate-900 mt-2">{{ $stats['implemented'] ?? 0 }}</div>
                        <div class="text-[11px] text-slate-500 mt-1">Dalam pengerjaan tim teknisi</div>
                    </div>

                    {{-- Closed --}}
                    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-xs border-l-4 border-l-emerald-600">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-500 uppercase">Selesai / Ditutup</span>
                            <span class="text-emerald-600 font-bold text-xs bg-emerald-50 px-2 py-0.5 rounded">Done</span>
                        </div>
                        <div class="text-2xl sm:text-3xl font-bold text-slate-900 mt-2">{{ $stats['closed'] ?? 0 }}</div>
                        <div class="text-[11px] text-slate-500 mt-1">Masalah tuntas diselesaikan</div>
                    </div>

                </div>

                {{-- Table Card --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
                    
                    {{-- Filter Tabs Bar --}}
                    <div class="p-4 border-b border-slate-100 bg-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <h2 class="text-sm font-bold text-slate-800">Daftar Pengaduan Masuk</h2>

                        <div class="flex flex-wrap items-center gap-1.5 text-xs font-semibold">
                            <button @click="activeTab = 'all'" 
                                    :class="activeTab === 'all' ? 'bg-[#1b2569] text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-300'"
                                    class="px-3 py-1.5 rounded-md transition-colors">
                                Semua ({{ $allTickets->count() }})
                            </button>
                            <button @click="activeTab = 'pending'" 
                                    :class="activeTab === 'pending' ? 'bg-amber-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-300'"
                                    class="px-3 py-1.5 rounded-md transition-colors">
                                Menunggu ({{ $stats['pending'] ?? 0 }})
                            </button>
                            <button @click="activeTab = 'accepted'" 
                                    :class="activeTab === 'accepted' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-300'"
                                    class="px-3 py-1.5 rounded-md transition-colors">
                                Diterima ({{ $stats['accepted'] ?? 0 }})
                            </button>
                            <button @click="activeTab = 'implemented'" 
                                    :class="activeTab === 'implemented' ? 'bg-purple-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-300'"
                                    class="px-3 py-1.5 rounded-md transition-colors">
                                Diterapkan ({{ $stats['implemented'] ?? 0 }})
                            </button>
                            <button @click="activeTab = 'closed'" 
                                    :class="activeTab === 'closed' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-300'"
                                    class="px-3 py-1.5 rounded-md transition-colors">
                                Selesai ({{ $stats['closed'] ?? 0 }})
                            </button>
                        </div>
                    </div>

                    {{-- Table --}}
                    @if($allTickets->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                                <thead class="bg-slate-50 text-slate-500 uppercase font-bold tracking-wider">
                                    <tr>
                                        <th class="px-5 py-3.5">ID & Judul</th>
                                        <th class="px-5 py-3.5">Pelapor</th>
                                        <th class="px-5 py-3.5">Kategori</th>
                                        <th class="px-5 py-3.5">Prioritas</th>
                                        <th class="px-5 py-3.5">Ubah Status</th>
                                        <th class="px-5 py-3.5">Tanggal</th>
                                        <th class="px-5 py-3.5 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($allTickets as $ticket)
                                        @php
                                            $catMap = [
                                                'academic'       => 'Akademik',
                                                'technical'      => 'Fasilitas & Teknik',
                                                'administrative' => 'Administrasi',
                                            ];
                                            $priMap = [
                                                'low'    => 'text-slate-600',
                                                'medium' => 'text-amber-700 font-semibold',
                                                'high'   => 'text-rose-700 font-bold',
                                            ];
                                            $priLabel = ['low' => 'Rendah', 'medium' => 'Sedang', 'high' => 'Tinggi'];
                                        @endphp
                                        <tr x-show="activeTab === 'all' || activeTab === '{{ $ticket->status }}'" class="hover:bg-slate-50 transition-colors">
                                            
                                            {{-- ID & Judul --}}
                                            <td class="px-5 py-3.5 max-w-xs">
                                                <div class="text-[10px] font-mono text-slate-400">#{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</div>
                                                <div class="font-bold text-slate-900 truncate">{{ $ticket->title }}</div>
                                                <div class="text-slate-500 truncate mt-0.5">
                                                    {{ strlen($ticket->description) > 45 ? substr($ticket->description, 0, 45) . '...' : $ticket->description }}
                                                </div>
                                            </td>

                                            {{-- Pelapor --}}
                                            <td class="px-5 py-3.5 whitespace-nowrap">
                                                <div class="font-semibold text-slate-900">{{ $ticket->user->name ?? '-' }}</div>
                                                <div class="text-[11px] text-slate-500 capitalize">{{ $ticket->user->role ?? '-' }}</div>
                                            </td>

                                            {{-- Kategori --}}
                                            <td class="px-5 py-3.5 whitespace-nowrap text-slate-700">
                                                {{ $catMap[$ticket->category] ?? $ticket->category }}
                                            </td>

                                            {{-- Prioritas --}}
                                            <td class="px-5 py-3.5 whitespace-nowrap">
                                                <span class="{{ $priMap[$ticket->priority] ?? 'text-slate-600' }}">
                                                    {{ $priLabel[$ticket->priority] ?? $ticket->priority }}
                                                </span>
                                            </td>

                                            {{-- Status Form --}}
                                            <td class="px-5 py-3.5 whitespace-nowrap">
                                                <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="flex items-center gap-1.5">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" class="text-xs py-1 px-2 rounded-md border-slate-300 bg-white focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                                                        <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                                        <option value="accepted" {{ $ticket->status == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                                        <option value="implemented" {{ $ticket->status == 'implemented' ? 'selected' : '' }}>Diterapkan</option>
                                                        <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Selesai</option>
                                                    </select>
                                                    <button type="submit" class="px-2 py-1 rounded-md bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold text-xs" title="Simpan">
                                                        Simpan
                                                    </button>
                                                </form>
                                            </td>

                                            {{-- Tanggal --}}
                                            <td class="px-5 py-3.5 whitespace-nowrap text-slate-500">
                                                {{ $ticket->created_at->format('d/m/Y H:i') }}
                                            </td>

                                            {{-- Aksi --}}
                                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('tickets.show', $ticket) }}" class="font-semibold text-blue-700 hover:underline">
                                                        Detail
                                                    </a>
                                                    <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" 
                                                          onsubmit="return confirm('Hapus pengaduan ini secara permanen?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-rose-600 hover:underline font-semibold" title="Hapus">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-12 px-4 text-center text-slate-400">
                            Belum ada laporan pengaduan masuk.
                        </div>
                    @endif

                </div>

            </main>

            {{-- Footer --}}
            <footer class="mt-auto py-4 px-8 border-t border-slate-200 bg-white text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
                <div>
                    &copy; {{ date('Y') }} STMIK Mardira Indonesia — Helpdesk Management.
                </div>
                <div>
                    Admin Panel
                </div>
            </footer>

        </div>

    </div>

</body>
</html>
