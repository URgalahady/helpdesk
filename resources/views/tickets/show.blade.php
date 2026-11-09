@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- Breadcrumb & Back Link --}}
    <div class="flex items-center justify-between">
        <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('dashboard') }}" 
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-[#1b2569] transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Kembali</span>
        </a>

        <span class="text-xs text-slate-500 font-mono font-medium">Tiket #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</span>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-xs uppercase tracking-wider">Berhasil</h4>
                    <p class="text-xs text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-sm font-semibold">&times;</button>
        </div>
    @endif

    {{-- Main Ticket Detail Card --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        
        {{-- Card Header --}}
        <div class="p-6 sm:p-7 border-b border-slate-200 bg-slate-50/60">
            @php
                $statusBadges = [
                    'pending'     => ['bg' => 'bg-amber-50 text-amber-700 border-amber-300', 'dot' => 'bg-amber-500', 'label' => 'Menunggu Review'],
                    'accepted'    => ['bg' => 'bg-blue-50 text-blue-700 border-blue-300', 'dot' => 'bg-blue-500', 'label' => 'Laporan Diterima'],
                    'implemented' => ['bg' => 'bg-indigo-50 text-indigo-700 border-indigo-300', 'dot' => 'bg-indigo-500', 'label' => 'Sedang Diterapkan'],
                    'closed'      => ['bg' => 'bg-emerald-50 text-emerald-700 border-emerald-300', 'dot' => 'bg-emerald-500', 'label' => 'Pengaduan Selesai'],
                ];
                $sb = $statusBadges[$ticket->status] ?? ['bg' => 'bg-slate-100 text-slate-700 border-slate-300', 'dot' => 'bg-slate-400', 'label' => ucfirst($ticket->status)];

                $catNames = [
                    'academic'       => 'Akademik & Perkuliahan',
                    'technical'      => 'Fasilitas & Masalah Teknik',
                    'administrative' => 'Administrasi & Layanan Kampus',
                ];

                $priBadges = [
                    'low'    => 'bg-slate-100 text-slate-700 border-slate-200',
                    'medium' => 'bg-amber-50 text-amber-700 border-amber-200',
                    'high'   => 'bg-rose-50 text-rose-700 border-rose-200 font-bold',
                ];
                $priLabels = ['low' => 'Rendah', 'medium' => 'Sedang', 'high' => 'Tinggi'];
            @endphp

            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-4">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $sb['bg'] }} mb-3">
                        <span class="w-1.5 h-1.5 rounded-full {{ $sb['dot'] }}"></span>
                        {{ $sb['label'] }}
                    </span>
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-900 leading-snug">
                        {{ $ticket->title }}
                    </h1>
                </div>

                <div class="sm:shrink-0 text-left sm:text-right">
                    <span class="text-xs text-slate-400 block">Waktu Pengajuan</span>
                    <span class="text-sm font-semibold text-slate-700">{{ $ticket->created_at->format('d M Y, H:i') }} WIB</span>
                </div>
            </div>

            {{-- Info Meta Strip --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 border-t border-slate-200 text-xs">
                <div>
                    <span class="text-slate-400 block mb-1 font-medium">Kategori</span>
                    <span class="font-bold text-slate-800">{{ $catNames[$ticket->category] ?? $ticket->category }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-1 font-medium">Prioritas</span>
                    <span class="inline-block px-2 py-0.5 rounded-md border text-[11px] {{ $priBadges[$ticket->priority] ?? '' }}">
                        {{ $priLabels[$ticket->priority] ?? $ticket->priority }}
                    </span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-1 font-medium">Pelapor</span>
                    <span class="font-bold text-slate-800">{{ $ticket->user->name ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-1 font-medium">Peran</span>
                    <span class="font-semibold text-[#1b2569] capitalize">{{ $ticket->user->role ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Description Body --}}
        <div class="p-6 sm:p-7 space-y-6">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Deskripsi & Rincian Pengaduan</h3>
                <div class="p-5 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 text-sm leading-relaxed whitespace-pre-line">
                    {{ $ticket->description }}
                </div>
            </div>

            {{-- Attachment --}}
            @if($ticket->attachment)
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Dokumen / Foto Lampiran</h3>
                    <div class="flex items-center gap-3 p-4 rounded-lg border border-slate-200 bg-white">
                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                        </div>
                        <div class="grow min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">Berkas Lampiran Pengaduan</p>
                            <p class="text-xs text-slate-500">Klik tautan di samping untuk membuka berkas</p>
                        </div>
                        <a href="{{ Storage::url($ticket->attachment) }}" target="_blank" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-[#1b2569] hover:bg-[#151d52] text-white font-semibold text-xs shadow-xs transition-colors shrink-0">
                            <span>Buka Lampiran</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endif

            {{-- Admin Control Panel --}}
            @if(Auth::user()->role === 'admin')
                <div class="pt-6 border-t border-slate-200">
                    <div class="rounded-lg p-5 bg-slate-900 text-white border border-slate-800">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <div>
                                <h4 class="font-bold text-sm">Tindakan Administrator</h4>
                                <p class="text-xs text-slate-400">Perbarui status tindak lanjut pengaduan</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                            @csrf
                            @method('PATCH')
                            <div class="grow">
                                <select name="status" 
                                        class="w-full rounded-md border-slate-700 bg-slate-800 text-white text-sm focus:border-indigo-400 focus:ring-1 focus:ring-indigo-400 py-2 px-3">
                                    <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Menunggu Review (Pending)</option>
                                    <option value="accepted" {{ $ticket->status == 'accepted' ? 'selected' : '' }}>Laporan Diterima (Accepted)</option>
                                    <option value="implemented" {{ $ticket->status == 'implemented' ? 'selected' : '' }}>Sedang Diterapkan (Implemented)</option>
                                    <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Selesai / Teratasi (Closed)</option>
                                </select>
                            </div>
                            <button type="submit" 
                                    class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-500 font-semibold text-xs text-white transition-colors shrink-0">
                                Simpan Perubahan Status
                            </button>
                        </form>

                        <div class="mt-4 pt-3 border-t border-slate-800 flex justify-end">
                            <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-rose-400 hover:text-rose-300 font-medium hover:underline flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Hapus Pengaduan Ini</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

        </div>

    </div>

</div>
@endsection
