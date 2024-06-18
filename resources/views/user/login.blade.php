@extends('layouts.blank')

@section('title', 'Inloggen')

@section('content')

    <form method="post" class="shadow p-4 border rounded mt-4 lg:mt-14 max-w-lg mx-auto">
        @csrf
        <h1 class="text-3xl mb-2">Login</h1>

        <div class="mb-3">
            <label for="email" class="block">Email</label>
            <input class="w-full p-2 rounded bg-gray-200" id="email" name="email" type="email" required
                value="{{ old('email') }}" />
        </div>
        <div class="mb-3">
            <label for="password" class="block">Wachtwoord</label>
            <input class="w-full p-2 rounded bg-gray-200" type="password" name="password" id="password">
        </div>

        <ul class="text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

        <div class="flex justify-end items-center">
            <button
                class="p-3 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors cursor-pointer">Inloggen</button>
        </div>

        <div class="flex items-center">
            <a href="{{ route('password.forgot') }}" class="text-blue-600">Wachtwoord vergeten?</a>
        </div>
    </form>

@endsection
