@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach(['pending'=>'Pengajuan','accepted'=>'Diterima','implemented'=>'Diterapkan','closed'=>'Ditutup'] as $status => $label)
            <div class="p-4 bg-white rounded shadow">
                <h2 class="text-lg font-medium">{{ $label }}</h2>
                <p class="text-3xl font-bold text-center mt-2">{{ $stats[$status] ?? 0 }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
