@extends('layouts.app')

@section('title', '404')

@section('content')
    <div class="flex justify-center items-center grow">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h1 class="text-4xl font-bold mb-4">404</h1>
            <p class="text-gray-600">
                Oeps! {{ $message ?? 'De pagina die je zoekt bestaat niet.'}}
            </p>
            <a href="/" class="mt-4 text-blue-500 hover:underline block">Ga terug naar Home</a>
        </div>
    </div>
@endsection
