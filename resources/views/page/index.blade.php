@extends('layouts.admin')

@section('title', 'Pagina overzicht')

@section('pageTitle', 'Pagina\'s')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 alert fade" role="alert">
            <span class="font-bold">Gelukt!</span>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <livewire:page-filter />

@endsection

@push('scripts')
    <script src="{{ asset('js/page/homepage-selector.js') }}"></script>
@endpush
