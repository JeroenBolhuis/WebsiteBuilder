@extends('layouts.blank')

@section('title', 'Wachtwoord vergeten')

@section('content')

<form method="post" class="shadow p-4 border rounded mt-4 lg:mt-14 max-w-lg mx-auto">
    @csrf
    <h1 class="text-3xl mb-2">Wachtwoord vergeten</h1>

    <div class="mb-3">
        <label for="email" class="block">Email</label>
        <input class="w-full p-2 rounded bg-gray-200" id="email" name="email" type="email" required
            value="{{ old('email') }}" />
    </div>

    <ul class="text-red-600">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

    @if (session('status'))
        <div class="bg-green-500 text-white p-3 rounded mb-3">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex justify-end items-center">
        <button
            class="p-3 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors cursor-pointer">Wachtwoord resetten</button>
    </div>
</form>    

@endsection
