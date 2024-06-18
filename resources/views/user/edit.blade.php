@extends('layouts.admin')
@section('title', 'Gebruiker ' . $user->name . ' bewerken')
@section('pageTitle', 'Gebruiker ' . $user->name . ' bewerken')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 alert fade" role="alert">
            <span class="font-bold">Gelukt!</span>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <form action="{{ route('user.update', ['user' => $user]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="font-bold text-lg pb-3">Gebruikersinformatie</h2>

            <div class="pl-2">
                <label for="name" class="font-bold">Gebruikersnaam *</label>
                <input name="name" id="name" type="text" class="w-full border p-1 px-2 my-1 rounded"
                    value="{{ old('username', $user->name) }}" required>
                @foreach ($errors->get('name') as $message)
                    <p class="text-red-600">{{ $message }}</p>
                @endforeach

                <label for="email" class="font-bold">E-mail *</label>
                <input type="email" id="email" name="email" class="w-full border p-1 px-2 my-1 mb-4 rounded"
                    value="{{ old('email', $user->email) }}" required>
                @foreach ($errors->get('email') as $message)
                    <p class="text-red-600">{{ $message }}</p>
                @endforeach

                <label for="password" class="font-bold">Nieuw wachtwoord</label>
                <input type="password" id="password" name="password" class="w-full border p-1 px-2 my-1 rounded">
                @foreach ($errors->get('password') as $message)
                    <p class="text-red-600">{{ $message }}</p>
                @endforeach

                <label for="password_confirmation" class="font-bold">Wachtwoord herhalen</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full border p-1 px-2 my-1 rounded">
                @foreach ($errors->get('password_confirmation') as $message)
                    <p class="text-red-600">{{ $message }}</p>
                @endforeach
            </div>
            <h2 class="font-bold text-lg py-3">Rechten</h2>
            <div class="pl-2">
                @foreach ($permissions as $permission)
                    <div>
                        <input type="checkbox" name="permissions[]" id="role-{{ $permission->id }}"
                            value="{{ $permission->name }}" {{ $me ? 'disabled' : '' }}
                            {{ $user->can($permission->name) ? 'checked' : '' }}>
                        <label for="role-{{ $permission->id }}">{{ __($permission->name) }}</label>
                    </div>
                @endforeach
            </div>
            @if ($me)
                <p class="text-red-900">Je kunt je eigen rechten niet aanpassen.</p>
            @endif

            @foreach ($errors->get('generic') as $message)
                <p class="text-red-600">{{ $message }}</p>
            @endforeach

            <div class="pt-3 flex justify-end">
                @can('delete user')
                    <button type="button" class="bg-red-500 text-white rounded p-2 px-3 mr-2"
                        onclick="showDeleteDialog({{ json_encode('de gebruiker ' . $user->name) }}, '{{ route('user.destroy', ['user' => $user]) }}')">Verwijderen</button>
                @endcan
                <button class="bg-green-500 text-white rounded p-2 px-3" id="save">Opslaan</button>
            </div>
        </div>
    </form>

    @can('delete user')
        <x-confirm-delete />
    @endcan
@endsection
