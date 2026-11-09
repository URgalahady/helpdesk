@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs font-semibold text-[#1b2569] uppercase tracking-wider">
        <a href="{{ route('dashboard.mahasiswa') }}" class="hover:underline">Dashboard Mahasiswa</a>
        <span class="text-slate-400">/</span>
        <span class="text-slate-600">Buat Pengaduan</span>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        {{-- Card Header --}}
        <div class="p-6 sm:p-7 border-b border-slate-200 bg-slate-50/70">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-[#1b2569] text-white flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-slate-900">Formulir Pengaduan Mahasiswa</h2>
                    <p class="text-xs text-slate-500">Sampaikan aspirasi, kendala perkuliahan, atau masalah sarana prasarana kampus</p>
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-7">
            <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- Judul --}}
                <div>
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Judul Pengaduan <span class="text-rose-500">*</span>
                    </label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}"
                        class="block w-full rounded-lg border-slate-300 shadow-xs focus:border-[#1b2569] focus:ring-1 focus:ring-[#1b2569] text-sm py-2 px-3"
                        placeholder="Contoh: AC Ruang Kuliah 3.2 Tidak Berfungsi Dingin" required autofocus>
                    @error('title')<p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>@enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Deskripsi Masalah Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="5"
                        class="block w-full rounded-lg border-slate-300 shadow-xs focus:border-[#1b2569] focus:ring-1 focus:ring-[#1b2569] text-sm py-2 px-3"
                        placeholder="Jelaskan secara rinci lokasi ruangan, waktu kejadian, dan detail keluhan Anda..." required>{{ old('description') }}</textarea>
                    @error('description')<p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>@enderror
                </div>

                {{-- Kategori & Prioritas --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Kategori Pengaduan <span class="text-rose-500">*</span>
                        </label>
                        <select id="category" name="category"
                            class="block w-full rounded-lg border-slate-300 shadow-xs focus:border-[#1b2569] focus:ring-1 focus:ring-[#1b2569] text-sm py-2 px-3" required>
                            <option value="" disabled {{ old('category') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                            <option value="academic" {{ old('category') == 'academic' ? 'selected' : '' }}>Akademik & Perkuliahan</option>
                            <option value="technical" {{ old('category') == 'technical' ? 'selected' : '' }}>Fasilitas & Masalah Teknik</option>
                            <option value="administrative" {{ old('category') == 'administrative' ? 'selected' : '' }}>Administrasi & Layanan</option>
                        </select>
                        @error('category')<p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="priority" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tingkat Urgensi / Prioritas <span class="text-rose-500">*</span>
                        </label>
                        <select id="priority" name="priority"
                            class="block w-full rounded-lg border-slate-300 shadow-xs focus:border-[#1b2569] focus:ring-1 focus:ring-[#1b2569] text-sm py-2 px-3" required>
                            <option value="" disabled {{ old('priority') ? '' : 'selected' }}>-- Pilih Prioritas --</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah (Informasi / Saran Berkala)</option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Sedang (Kendala Non-Kritis)</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi (Mendesak / Mengganggu Belajar)</option>
                        </select>
                        @error('priority')<p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Lampiran --}}
                <div>
                    <label for="attachment" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Lampiran Foto / Dokumen <span class="text-slate-400 font-normal lowercase">(opsional, maks. 2MB)</span>
                    </label>
                    <div class="p-3 rounded-lg border border-dashed border-slate-300 bg-slate-50/50">
                        <input id="attachment" type="file" name="attachment"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-800 hover:file:bg-slate-300">
                    </div>
                    @error('attachment')<p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p>@enderror
                </div>

                {{-- Action Buttons --}}
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-4">
                    <a href="{{ route('dashboard.mahasiswa') }}" 
                       class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition-colors">
                        &larr; Batal & Kembali
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1b2569] hover:bg-[#151d52] text-white font-semibold text-xs rounded-lg shadow-sm transition-colors">
                        <span>Kirim Pengaduan</span>
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
