<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Buat Pengaduan') }}</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <x-input-label for="title" :value="__('Judul')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <!-- Description -->
            <div class="mb-4">
                <x-input-label for="description" :value="__('Deskripsi')" />
                <textarea id="description" name="description" rows="5" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- Category -->
            <div class="mb-4">
                <x-input-label for="category" :value="__('Kategori')" />
                <select id="category" name="category" class="block mt-1 w-full" required>
                    <option value="academic" {{ old('category') == 'academic' ? 'selected' : '' }}>Akademik</option>
                    <option value="technical" {{ old('category') == 'technical' ? 'selected' : '' }}>Teknik</option>
                    <option value="administrative" {{ old('category') == 'administrative' ? 'selected' : '' }}>Administratif</option>
                </select>
                <x-input-error :messages="$errors->get('category')" class="mt-2" />
            </div>

            <!-- Priority -->
            <div class="mb-4">
                <x-input-label for="priority" :value="__('Prioritas')" />
                <select id="priority" name="priority" class="block mt-1 w-full" required>
                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                </select>
                <x-input-error :messages="$errors->get('priority')" class="mt-2" />
            </div>

            <!-- Attachment (optional) -->
            <div class="mb-4">
                <x-input-label for="attachment" :value="__('Lampiran (opsional)')" />
                <x-text-input id="attachment" class="block mt-1 w-full" type="file" name="attachment" />
                <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
            </div>

            <x-primary-button class="ml-4">
                {{ __('Kirim Pengaduan') }}
            </x-primary-button>
        </form>
    </div>
</x-app-layout>
