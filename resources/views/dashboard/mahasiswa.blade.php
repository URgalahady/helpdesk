@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-100 py-6 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Flash message --}}
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

        {{-- Hero Banner (Matches LMS STMIK Mardira Design) --}}
        <div class="rounded-2xl bg-gradient-to-r from-[#0284c7] via-[#0369a1] to-[#1e40af] text-white shadow-md p-6 sm:p-8">
            <div class="max-w-3xl space-y-4">
                
                {{-- Badge --}}
                <div>
                    <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-xs font-medium text-white tracking-wide">
                        Dashboard Mahasiswa
                    </span>
                </div>

                {{-- Welcome Title --}}
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                    Selamat datang, {{ Auth::user()->name }}
                </h1>

                {{-- Subtitle --}}
                <p class="text-xs sm:text-sm text-blue-100 leading-relaxed">
                    Pantau aktivitas akademik, tugas, forum, dan perkembangan kelas Anda dalam satu halaman.
                </p>

                {{-- 3 Horizontal Info Cards (NIM, Program Studi, Semester) --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                    <div class="bg-white/10 rounded-xl p-3 border border-white/15">
                        <div class="text-[10px] text-blue-200 uppercase font-semibold">NIM</div>
                        <div class="text-sm sm:text-base font-bold text-white mt-0.5">24110{{ str_pad(Auth::user()->id, 3, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-3 border border-white/15">
                        <div class="text-[10px] text-blue-200 uppercase font-semibold">Program Studi</div>
                        <div class="text-sm sm:text-base font-bold text-white mt-0.5">Teknik Informatika</div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-3 border border-white/15">
                        <div class="text-[10px] text-blue-200 uppercase font-semibold">Semester</div>
                        <div class="text-sm sm:text-base font-bold text-white mt-0.5">5</div>
                    </div>
                </div>

                {{-- Quote Box --}}
                <div class="bg-white/10 rounded-lg px-4 py-2.5 border border-white/15 text-xs text-blue-100 flex items-center gap-2">
                    <span class="text-sm opacity-70">❝</span>
                    <span class="italic">Patience is the healthiest ingredient of our life.</span>
                    <span class="font-semibold text-white ml-auto sm:ml-2">— Umar ibn Al-Khattab (R.A)</span>
                </div>

            </div>
        </div>

        {{-- Content Area Below Hero (2 Columns) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- Left Column: Pengumuman & Pengaduan (8 Columns) --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white rounded-xl p-6 shadow-xs border border-slate-200">
                    
                    {{-- Header with Announcement Icon --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-3 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 text-[#1b2569] flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-sm sm:text-base font-bold text-slate-800">Pengumuman & Pengaduan</h2>
                                <p class="text-xs text-slate-500">Informasi umum dan perkembangan tindak lanjut pengaduan kelas.</p>
                            </div>
                        </div>

                        <a href="{{ route('tickets.create.mahasiswa') }}" 
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#1b2569] hover:bg-[#151d52] text-white text-xs font-semibold transition-colors shadow-xs shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Buat Pengaduan</span>
                        </a>
                    </div>

                    {{-- Tickets List or Empty Box --}}
                    @php $tickets = Auth::user()->tickets()->orderBy('created_at','desc')->get(); @endphp
                    @if($tickets->count() > 0)
                        <div class="divide-y divide-slate-100">
                            @foreach($tickets as $ticket)
                                @php
                                    $statusBadges = [
                                        'pending'     => ['bg' => 'bg-amber-50 text-amber-800 border-amber-200', 'label' => 'Menunggu Review'],
                                        'accepted'    => ['bg' => 'bg-blue-50 text-blue-800 border-blue-200', 'label' => 'Diterima'],
                                        'implemented' => ['bg' => 'bg-purple-50 text-purple-800 border-purple-200', 'label' => 'Sedang Diterapkan'],
                                        'closed'      => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'label' => 'Selesai'],
                                    ];
                                    $sb = $statusBadges[$ticket->status] ?? ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'label' => ucfirst($ticket->status)];
                                @endphp
                                <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold border {{ $sb['bg'] }}">
                                                {{ $sb['label'] }}
                                            </span>
                                            <span class="text-xs text-slate-400">{{ $ticket->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                        <h3 class="text-sm font-semibold text-slate-900">{{ $ticket->title }}</h3>
                                        <p class="text-xs text-slate-500 line-clamp-1">
                                            {{ strlen($ticket->description) > 70 ? substr($ticket->description, 0, 70) . '...' : $ticket->description }}
                                        </p>
                                    </div>
                                    <a href="{{ route('tickets.show', $ticket) }}" 
                                       class="inline-flex items-center gap-1 text-xs font-semibold text-[#1b2569] hover:underline shrink-0">
                                        <span>Lihat Detail</span>
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Empty Announcement Box (Matches LMS Screenshot) --}}
                        <div class="border border-slate-200 bg-slate-50 rounded-xl py-12 px-4 text-center">
                            <h3 class="text-sm font-bold text-slate-800">Tidak ada pengumuman</h3>
                            <p class="text-xs text-slate-500 mt-1">Belum ada pengumuman yang tersedia saat ini.</p>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Right Column: Aktivitas Saya (4 Columns) --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-xl p-6 shadow-xs border border-slate-200" x-data="{ taskOpen: true, forumOpen: false }">
                    
                    {{-- Header with Activity Icon --}}
                    <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 mb-4">
                        <svg class="w-5 h-5 text-[#1b2569]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <h2 class="text-sm sm:text-base font-bold text-slate-800">Aktivitas Saya</h2>
                    </div>

                    {{-- Accordion 1: Daftar Tugas --}}
                    <div class="border border-slate-200 rounded-lg mb-3 overflow-hidden">
                        <button @click="taskOpen = !taskOpen" class="w-full flex items-center justify-between p-3 text-left text-xs font-semibold text-slate-700 bg-slate-50/50 hover:bg-slate-100 transition-colors">
                            <span>Daftar Tugas & Pengaduan Aktif</span>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-full text-[10px] bg-blue-100 text-blue-800 font-bold">
                                    {{ ($stats['pending'] ?? 0) + ($stats['accepted'] ?? 0) + ($stats['implemented'] ?? 0) }}
                                </span>
                                <svg class="w-4 h-4 text-slate-400 transform transition-transform" :class="{ 'rotate-180': taskOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="taskOpen" class="p-3 text-xs text-slate-600 border-t border-slate-200 bg-white space-y-2">
                            <div class="flex justify-between py-1 border-b border-slate-100">
                                <span>Menunggu Review:</span>
                                <span class="font-bold text-amber-600">{{ $stats['pending'] ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-slate-100">
                                <span>Diterima Admin:</span>
                                <span class="font-bold text-blue-600">{{ $stats['accepted'] ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span>Sedang Diterapkan:</span>
                                <span class="font-bold text-purple-600">{{ $stats['implemented'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Accordion 2: Aktivitas Forum / Selesai --}}
                    <div class="border border-slate-200 rounded-lg overflow-hidden">
                        <button @click="forumOpen = !forumOpen" class="w-full flex items-center justify-between p-3 text-left text-xs font-semibold text-slate-700 bg-slate-50/50 hover:bg-slate-100 transition-colors">
                            <span>Aktivitas Forum & Riwayat Selesai</span>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-full text-[10px] bg-emerald-100 text-emerald-800 font-bold">
                                    {{ $stats['closed'] ?? 0 }}
                                </span>
                                <svg class="w-4 h-4 text-slate-400 transform transition-transform" :class="{ 'rotate-180': forumOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="forumOpen" class="p-3 text-xs text-slate-600 border-t border-slate-200 bg-white">
                            <p>Total pengaduan yang telah diselesaikan: <strong class="text-emerald-700">{{ $stats['closed'] ?? 0 }} laporan</strong>.</p>
                        </div>
                    </div>

                    {{-- Help Box --}}
                    <div class="mt-4 p-3 rounded-lg bg-blue-50 border border-blue-100 text-xs text-blue-900">
                        <p class="font-bold mb-1">Layanan Bantuan</p>
                        <p class="text-[11px] text-blue-800 leading-relaxed">
                            Jika terdapat kendala darurat perkuliahan atau fasilitas, silakan laporkan ke bagian sarana kampus.
                        </p>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection
