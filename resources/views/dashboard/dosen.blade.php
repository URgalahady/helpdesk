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

        {{-- Notifikasi status pengaduan (popup tengah, ringkas) --}}
        @if(isset($statusNotifications) && $statusNotifications->count() > 0)
            @php
                $notifPayload = $statusNotifications->map(function ($notif) {
                    $messages = [
                        'accepted' => 'Pengaduan "'.$notif->title.'" telah diterima. Terima kasih atas laporannya.',
                        'implemented' => 'Pengaduan "'.$notif->title.'" sedang ditindaklanjuti.',
                        'closed' => 'Pengaduan "'.$notif->title.'" telah selesai direalisasikan. Terima kasih atas saran Anda.',
                    ];
                    $labels = ['accepted' => 'Diterima', 'implemented' => 'Diproses', 'closed' => 'Selesai'];
                    return [
                        'id' => $notif->id,
                        'status' => $notif->status,
                        'label' => $labels[$notif->status] ?? ucfirst($notif->status),
                        'message' => $messages[$notif->status] ?? 'Status pengaduan "'.$notif->title.'" diperbarui.',
                        'url' => route('tickets.notification.read', $notif),
                    ];
                })->values();
            @endphp
            <div x-data="{
                    open: false,
                    items: {{ Js::from($notifPayload) }},
                    statusClass(s) {
                        return {
                            accepted: 'border-blue-200 bg-blue-50/80',
                            implemented: 'border-purple-200 bg-purple-50/80',
                            closed: 'border-emerald-200 bg-emerald-50/80',
                        }[s] || 'border-slate-200 bg-slate-50';
                    },
                    badgeClass(s) {
                        return {
                            accepted: 'bg-blue-600',
                            implemented: 'bg-purple-600',
                            closed: 'bg-emerald-600',
                        }[s] || 'bg-slate-600';
                    },
                    async dismiss(item, idx) {
                        try {
                            await fetch(item.url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({ _method: 'PATCH' })
                            });
                        } catch (e) {}
                        this.items.splice(idx, 1);
                        if (this.items.length === 0) this.open = false;
                    }
                 }"
                 x-init="setTimeout(() => open = true, 80)"
                 x-show="open && items.length"
                 x-cloak
                 class="fixed inset-0 z-[60] flex items-center justify-center p-3 sm:p-4">
                <div x-show="open && items.length"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0 bg-slate-900/40 backdrop-blur-[1px]"
                     @click="open = false"></div>

                <div x-show="open && items.length"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 sm:scale-95"
                     class="relative w-full max-w-sm bg-white rounded-xl shadow-xl border border-slate-200 overflow-hidden">
                    <div class="px-4 py-2.5 bg-gradient-to-r from-[#0284c7] to-[#1e40af] text-white flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="relative flex h-2 w-2 shrink-0">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-60"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                            </span>
                            <div class="min-w-0">
                                <div class="text-[13px] font-semibold leading-tight">Pembaruan Status</div>
                                <div class="text-[10px] text-blue-100 leading-tight truncate" x-text="items.length + ' notifikasi baru'"></div>
                            </div>
                        </div>
                        <button @click="open = false" class="shrink-0 text-white/80 hover:text-white text-lg leading-none font-bold px-1" aria-label="Tutup">&times;</button>
                    </div>

                    <div class="p-2.5 space-y-2 max-h-[50vh] overflow-y-auto">
                        <template x-for="(item, idx) in items" :key="item.id + '-' + item.status">
                            <div class="rounded-lg border px-3 py-2.5 transition-all" :class="statusClass(item.status)">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0 space-y-1">
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold text-white uppercase tracking-wide" :class="badgeClass(item.status)" x-text="item.label"></span>
                                        <p class="text-[12px] leading-snug text-slate-800 break-words" x-text="item.message"></p>
                                    </div>
                                    <button @click="dismiss(item, idx)" class="shrink-0 px-2 py-1 rounded-md bg-white hover:bg-slate-50 border border-slate-200 text-slate-600 text-[11px] font-semibold">Tutup</button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="px-3 py-2 bg-slate-50 border-t border-slate-100 text-[10px] text-slate-500 flex items-center justify-between gap-2">
                        <span class="leading-tight">Muncul lagi jika status berubah.</span>
                        <button @click="open = false" class="shrink-0 font-semibold text-[#1b2569] hover:underline">Nanti</button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Hero Banner --}}
        <div class="rounded-2xl bg-gradient-to-r from-[#0284c7] via-[#0369a1] to-[#1e40af] text-white shadow-md p-6 sm:p-8">
            <div class="max-w-3xl space-y-4">
                
                {{-- Badge --}}
                <div>
                    <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-xs font-medium text-white tracking-wide">
                        Dashboard Dosen
                    </span>
                </div>

                {{-- Welcome Title --}}
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                    Selamat datang, Bapak/Ibu {{ Auth::user()->name }}
                </h1>

                {{-- Subtitle --}}
                <p class="text-xs sm:text-sm text-blue-100 leading-relaxed">
                    Pantau kebutuhan sarana ruang kuliah, kendala teknis sistem, dan usulan fasilitas pembelajaran kampus.
                </p>

                {{-- 3 Horizontal Info Cards (NIDN/NIP, Program Studi/Jurusan, Status) --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                    <div class="bg-white/10 rounded-xl p-3 border border-white/15">
                        <div class="text-[10px] text-blue-200 uppercase font-semibold">NIDN / NIP</div>
                        <div class="text-sm sm:text-base font-bold text-white mt-0.5">{{ Auth::user()->nidn_nip ?: 'Belum diatur admin' }}</div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-3 border border-white/15">
                        <div class="text-[10px] text-blue-200 uppercase font-semibold">Program Studi</div>
                        <div class="text-sm sm:text-base font-bold text-white mt-0.5">{{ Auth::user()->program_studi ?: (Auth::user()->jurusan ?: 'Belum diatur admin') }}</div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-3 border border-white/15">
                        <div class="text-[10px] text-blue-200 uppercase font-semibold">Status Pengajar</div>
                        <div class="text-sm sm:text-base font-bold text-white mt-0.5">{{ Auth::user()->status_pengajar ?: 'Belum diatur admin' }}</div>
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
                    
                    {{-- Header --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-3 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 text-[#1b2569] flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-sm sm:text-base font-bold text-slate-800">Laporan & Pengumuman Fasilitas</h2>
                                <p class="text-xs text-slate-500">Daftar permohonan sarana ruang kuliah dan koordinasi perbaikan.</p>
                            </div>
                        </div>

                        <a href="{{ route('tickets.create.dosen') }}" 
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-[#1b2569] hover:bg-[#151d52] text-white text-xs font-semibold transition-colors shadow-xs shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Buat Laporan Baru</span>
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
                        {{-- Empty Announcement Box --}}
                        <div class="border border-slate-200 bg-slate-50 rounded-xl py-12 px-4 text-center">
                            <h3 class="text-sm font-bold text-slate-800">Tidak ada pengumuman</h3>
                            <p class="text-xs text-slate-500 mt-1">Belum ada pengumuman atau usulan fasilitas yang diajukan saat ini.</p>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Right Column: Aktivitas Saya (4 Columns) --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-xl p-6 shadow-xs border border-slate-200" x-data="{ taskOpen: true, forumOpen: false }">
                    
                    {{-- Header --}}
                    <div class="flex items-center gap-2.5 pb-4 border-b border-slate-100 mb-4">
                        <svg class="w-5 h-5 text-[#1b2569]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <h2 class="text-sm sm:text-base font-bold text-slate-800">Aktivitas Saya</h2>
                    </div>

                    {{-- Accordion 1: Laporan Fasilitas Aktif --}}
                    <div class="border border-slate-200 rounded-lg mb-3 overflow-hidden">
                        <button @click="taskOpen = !taskOpen" class="w-full flex items-center justify-between p-3 text-left text-xs font-semibold text-slate-700 bg-slate-50/50 hover:bg-slate-100 transition-colors">
                            <span>Laporan Fasilitas Aktif</span>
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

                    {{-- Accordion 2: Laporan Selesai --}}
                    <div class="border border-slate-200 rounded-lg overflow-hidden">
                        <button @click="forumOpen = !forumOpen" class="w-full flex items-center justify-between p-3 text-left text-xs font-semibold text-slate-700 bg-slate-50/50 hover:bg-slate-100 transition-colors">
                            <span>Laporan Selesai Direalisasikan</span>
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
                            <p>Total permohonan yang telah selesai ditangani: <strong class="text-emerald-700">{{ $stats['closed'] ?? 0 }} laporan</strong>.</p>
                        </div>
                    </div>

                    {{-- Help Box --}}
                    <div class="mt-4 p-3 rounded-lg bg-blue-50 border border-blue-100 text-xs text-blue-900">
                        <p class="font-bold mb-1">Koordinasi Ruang Kuliah</p>
                        <p class="text-[11px] text-blue-800 leading-relaxed">
                            Kebutuhan mendesak proyektor atau software laboratorium dapat dikoordinasikan langsung ke Kepala Lab Komputer.
                        </p>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection
