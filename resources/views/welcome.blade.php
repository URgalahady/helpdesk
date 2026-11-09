<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Helpdesk Kampus — STMIK Mardira Indonesia</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased font-['Figtree',sans-serif]">

    {{-- Top Navbar matching LMS STMIK Mardira --}}
    <nav class="bg-[#1b2569] text-white border-b border-[#253285] sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo and Title --}}
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo STMIK Mardira" class="w-10 h-10 object-contain rounded-md bg-white p-0.5">
                    <div>
                        <div class="text-[10px] text-blue-200 tracking-wider uppercase font-semibold">Helpdesk & Layanan Aspirasi</div>
                        <div class="text-sm sm:text-base font-bold tracking-tight text-white leading-tight">STMIK MARDIRA INDONESIA</div>
                    </div>
                </div>

                {{-- Action Links --}}
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                           class="inline-flex items-center px-4 py-2 text-xs font-semibold rounded-md bg-white text-[#1b2569] hover:bg-blue-50 transition-colors shadow-xs">
                            Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="text-xs font-semibold px-3 py-2 text-blue-100 hover:text-white transition-colors">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="inline-flex items-center px-3.5 py-1.5 text-xs font-semibold rounded-md bg-white text-[#1b2569] hover:bg-blue-50 transition-colors shadow-xs">
                                Registrasi
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="bg-gradient-to-b from-[#1b2569] via-[#202c7b] to-[#263593] text-white py-14 sm:py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto text-center space-y-5">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-blue-100 border border-white/20">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Sistem Pengaduan Terpadu Kampus
            </div>

            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight">
                Layanan Pengaduan & Aspirasi Civitas Akademika
            </h1>

            <p class="text-sm sm:text-base text-blue-100/90 max-w-2xl mx-auto leading-relaxed">
                Saluran resmi terintegrasi bagi mahasiswa dan dosen STMIK Mardira Indonesia untuk menyampaikan kendala sarana, fasilitas kelas, dan administrasi akademik secara transparan.
            </p>

            <div class="pt-4 flex flex-wrap justify-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-white text-[#1b2569] hover:bg-blue-50 font-bold text-xs rounded-lg shadow-sm transition-colors">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-white text-[#1b2569] hover:bg-blue-50 font-bold text-xs rounded-lg shadow-sm transition-colors">
                        Sampaikan Pengaduan Sekarang
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-5 py-2.5 border border-white/40 text-white hover:bg-white/10 font-bold text-xs rounded-lg transition-colors">
                            Daftar Akun Baru
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </section>

    {{-- Summary KPI Ribbon --}}
    @php
        $totalTickets = \App\Models\Ticket::count();
        $selesai      = \App\Models\Ticket::where('status', 'closed')->count();
        $totalUsers   = \App\Models\User::count();
        $prosesCount  = \App\Models\Ticket::whereIn('status', ['accepted', 'implemented'])->count();
    @endphp
    <div class="max-w-5xl mx-auto px-4 -mt-8">
        <div class="bg-white rounded-xl shadow-md border border-slate-200 grid grid-cols-2 sm:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-slate-100 py-4">
            <div class="text-center p-3">
                <div class="text-2xl font-extrabold text-[#1b2569]">{{ $totalTickets }}</div>
                <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mt-0.5">Total Pengaduan</div>
            </div>
            <div class="text-center p-3">
                <div class="text-2xl font-extrabold text-blue-600">{{ $prosesCount }}</div>
                <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mt-0.5">Sedang Ditangani</div>
            </div>
            <div class="text-center p-3">
                <div class="text-2xl font-extrabold text-emerald-600">{{ $selesai }}</div>
                <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mt-0.5">Selesai / Teratasi</div>
            </div>
            <div class="text-center p-3">
                <div class="text-2xl font-extrabold text-slate-700">{{ $totalUsers }}</div>
                <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider mt-0.5">Pengguna Aktif</div>
            </div>
        </div>
    </div>

    {{-- Progress Flow Alur Pengaduan --}}
    <section class="max-w-6xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-12">
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Alur Penyelesaian Masalah</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Transparansi setiap tahapan pengaduan dari pengiriman hingga bukti selesai pengerjaan</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 relative">

            {{-- Step 1 --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold text-xs flex items-center justify-center">1</span>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Tahap 1</span>
                </div>
                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-sm mb-1">Pengajuan Tiket</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Mahasiswa atau dosen mengisi formulir detail keluhan disertai foto/berkas bukti kendala.
                </p>
            </div>

            {{-- Step 2 --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold text-xs flex items-center justify-center">2</span>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Tahap 2</span>
                </div>
                <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-sm mb-1">Verifikasi & Review</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Tim helpdesk meninjau keluhan, menetapkan tingkat prioritas, dan meneruskan ke divisi terkait.
                </p>
            </div>

            {{-- Step 3 --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs relative">
                <div class="flex items-center justify-between mb-3">
                    <span class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold text-xs flex items-center justify-center">3</span>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Tahap 3</span>
                </div>
                <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-sm mb-1">Pengerjaan di Lapangan</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Petugas teknis kampus melakukan perbaikan fasilitas fisik maupun penyesuaian sistem informasi.
                </p>
            </div>

            {{-- Step 4 --}}
            <div class="bg-white rounded-xl border border-emerald-300 p-5 shadow-xs relative bg-emerald-50/20">
                <div class="flex items-center justify-between mb-3">
                    <span class="w-7 h-7 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center">✓</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700">Tahap Akhir</span>
                </div>
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 text-sm mb-1">Tiket Selesai</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Laporan ditutup dengan konfirmasi perbaikan selesai dan notifikasi pembaruan pada pelapor.
                </p>
            </div>

        </div>
    </section>

    {{-- Civitas Roles --}}
    <section class="bg-white border-y border-slate-200 py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center max-w-xl mx-auto mb-10">
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Akses Berdasarkan Peran</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Dirancang khusus untuk mendukung operasional sivitas STMIK Mardira Indonesia</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Mahasiswa --}}
                <div class="p-6 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-[#1b2569]/30 transition-all">
                    <div class="w-9 h-9 rounded-md bg-[#1b2569] text-white flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-base text-slate-900">Mahasiswa</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Pengaduan sarana ruang kuliah, pendingin ruangan (AC), proyektor, koneksi Wi-Fi kampus, serta layanan administrasi pengajaran.
                    </p>
                </div>

                {{-- Dosen --}}
                <div class="p-6 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-[#1b2569]/30 transition-all">
                    <div class="w-9 h-9 rounded-md bg-[#1b2569] text-white flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-base text-slate-900">Dosen Pengajar</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Laporan sarana laboratorium praktikum, kebutuhan perangkat perkuliahan, kendala input nilai, dan koordinasi staf teknis.
                    </p>
                </div>

                {{-- Admin --}}
                <div class="p-6 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-[#1b2569]/30 transition-all">
                    <div class="w-9 h-9 rounded-md bg-[#1b2569] text-white flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-base text-slate-900">Admin Panel</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Dashboard monitoring terpusat untuk memverifikasi, menetapkan tindakan, memperbarui status tiket, dan menjaga SLA kampus.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-slate-900 text-slate-400 py-8 px-4 text-center text-xs">
        <div class="max-w-4xl mx-auto space-y-2">
            <p class="font-medium text-slate-300">STMIK MARDIRA INDONESIA — Kampus Teknologi Informasi & Komputer</p>
            <p>&copy; {{ date('Y') }} Sistem Informasi Layanan Helpdesk & Aspirasi. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>
</html>
