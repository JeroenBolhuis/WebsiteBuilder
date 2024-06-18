@extends('layouts.blank')

@section('title', 'Reset Wachtwoord')

@section('content')

    <form method="post" action="{{route('password.reset.submit')}}" class="shadow p-4 border rounded mt-4 lg:mt-14 max-w-lg mx-auto">
        @csrf
        <h1 class="text-3xl mb-2">Reset Wachtwoord</h1>

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label for="email" class="block">Email</label>
            <input readonly class="w-full p-2 rounded bg-gray-200" id="email" name="email" type="email" required
                value="{{ request('email') ?? old('email') }}" />
        </div>

        <div class="mb-3">
            <label for="password" class="block">Nieuw Wachtwoord</label>
            <input class="w-full p-2 rounded bg-gray-200" type="password" name="password" id="password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="block">Bevestig Nieuw Wachtwoord</label>
            <input class="w-full p-2 rounded bg-gray-200" type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <ul class="text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

        <div class="flex justify-end items-center">
            <button
                class="p-3 bg-green-700 text-white rounded-lg hover:bg-green-800 transition-colors cursor-pointer">Verander wachtwoord</button>
        </div>
    </form>

@endsection