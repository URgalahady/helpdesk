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

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:underline text-[#1b2569]">Dashboard</a>
                    <span>/</span>
                    <span>Daftar Pengaduan</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900">
                    @if(Auth::user()->role === 'admin')
                        Daftar Seluruh Pengaduan Masuk
                    @else
                        Daftar Pengaduan Saya
                    @endif
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    @if(Auth::user()->role === 'admin')
                        Kelola dan tinjau seluruh laporan pengaduan civitas akademika STMIK Mardira Indonesia.
                    @else
                        Riwayat laporan dan aspirasi yang telah Anda ajukan.
                    @endif
                </p>
            </div>

            <div>
                @if(Auth::user()->role === 'mahasiswa')
                    <a href="{{ route('tickets.create.mahasiswa') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#1b2569] hover:bg-[#151d52] text-white font-semibold text-xs rounded-lg shadow-xs transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Buat Pengaduan Baru</span>
                    </a>
                @elseif(Auth::user()->role === 'dosen')
                    <a href="{{ route('tickets.create.dosen') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#1b2569] hover:bg-[#151d52] text-white font-semibold text-xs rounded-lg shadow-xs transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Buat Pengaduan Baru</span>
                    </a>
                @endif
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
            @if($tickets->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase font-bold tracking-wider">
                            <tr>
                                <th class="px-5 py-3.5">ID & Judul</th>
                                @if(Auth::user()->role === 'admin')
                                    <th class="px-5 py-3.5">Pelapor</th>
                                @endif
                                <th class="px-5 py-3.5">Kategori</th>
                                <th class="px-5 py-3.5">Prioritas</th>
                                <th class="px-5 py-3.5">Status</th>
                                <th class="px-5 py-3.5">Tanggal</th>
                                <th class="px-5 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($tickets as $ticket)
                                @php
                                    $statusBadges = [
                                        'pending'     => ['bg' => 'bg-amber-50 text-amber-800 border-amber-200', 'label' => 'Menunggu Review'],
                                        'accepted'    => ['bg' => 'bg-blue-50 text-blue-800 border-blue-200', 'label' => 'Diterima'],
                                        'implemented' => ['bg' => 'bg-purple-50 text-purple-800 border-purple-200', 'label' => 'Sedang Diterapkan'],
                                        'closed'      => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'label' => 'Selesai'],
                                    ];
                                    $sb = $statusBadges[$ticket->status] ?? ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'label' => ucfirst($ticket->status)];

                                    $catNames = [
                                        'academic'       => 'Akademik',
                                        'technical'      => 'Fasilitas & Teknik',
                                        'administrative' => 'Administrasi',
                                    ];

                                    $priBadges = [
                                        'low'    => 'text-slate-600',
                                        'medium' => 'text-amber-700 font-semibold',
                                        'high'   => 'text-rose-700 font-bold',
                                    ];
                                    $priLabels = ['low' => 'Rendah', 'medium' => 'Sedang', 'high' => 'Tinggi'];
                                @endphp
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-5 py-3.5 max-w-xs">
                                        <div class="text-[10px] font-mono text-slate-400">#{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}</div>
                                        <div class="font-bold text-slate-900 truncate">{{ $ticket->title }}</div>
                                        <div class="text-slate-500 truncate mt-0.5">
                                            {{ strlen($ticket->description) > 50 ? substr($ticket->description, 0, 50) . '...' : $ticket->description }}
                                        </div>
                                    </td>
                                    @if(Auth::user()->role === 'admin')
                                        <td class="px-5 py-3.5 whitespace-nowrap">
                                            <div class="font-semibold text-slate-900">{{ $ticket->user->name ?? '-' }}</div>
                                            <div class="text-[11px] text-slate-500 capitalize">{{ $ticket->user->role ?? '-' }}</div>
                                        </td>
                                    @endif
                                    <td class="px-5 py-3.5 whitespace-nowrap text-slate-700">
                                        {{ $catNames[$ticket->category] ?? $ticket->category }}
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        <span class="{{ $priBadges[$ticket->priority] ?? 'text-slate-600' }}">
                                            {{ $priLabels[$ticket->priority] ?? $ticket->priority }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap">
                                        <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold border {{ $sb['bg'] }}">
                                            {{ $sb['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap text-slate-500">
                                        {{ $ticket->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                        <a href="{{ route('tickets.show', $ticket) }}" 
                                           class="inline-flex items-center gap-1 font-semibold text-[#1b2569] hover:underline">
                                            <span>Lihat Detail</span>
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100 bg-slate-50">
                    {{ $tickets->links() }}
                </div>
            @else
                <div class="py-12 px-4 text-center text-slate-400">
                    <p class="text-sm font-semibold text-slate-700">Belum Ada Pengaduan</p>
                    <p class="text-xs text-slate-500 mt-1">Tidak ditemukan data pengaduan untuk ditampilkan saat ini.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
