@extends('layouts.admin')
@section('title', 'Gebruiker aanmaken')
@section('pageTitle', 'Gebruiker aanmaken')

@section('content')

    <form action="{{ route('user.store') }}" method="POST">
        @csrf

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="font-bold text-lg pb-3">Gebruikersinformatie</h2>

            <div class="pl-2">
                <label for="name" class="font-bold">Gebruikersnaam *</label>
                <input name="name" id="name" type="text" class="w-full border p-1 px-2 my-1 rounded"
                    value="{{ old('username') }}" required>
                @foreach ($errors->get('name') as $message)
                    <p class="text-red-600">{{ $message }}</p>
                @endforeach

                <label for="email" class="font-bold">E-mail *</label>
                <input type="email" id="email" name="email" class="w-full border p-1 px-2 my-1 mb-4 rounded"
                    value="{{ old('email') }}" required>
                @foreach ($errors->get('email') as $message)
                    <p class="text-red-600">{{ $message }}</p>
                @endforeach

                <label for="password" class="font-bold">Wachtwoord *</label>
                <input type="password" id="password" name="password" class="w-full border p-1 px-2 my-1 rounded" required>
                @foreach ($errors->get('password') as $message)
                    <p class="text-red-600">{{ $message }}</p>
                @endforeach

                <label for="password_confirmation" class="font-bold">Wachtwoord herhalen *</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full border p-1 px-2 my-1 rounded" required>
                @foreach ($errors->get('password_confirmation') as $message)
                    <p class="text-red-600">{{ $message }}</p>
                @endforeach
            </div>

            <h2 class="font-bold text-lg py-3">Rechten</h2>
            <div class="pl-2">
                @foreach ($permissions as $permission)
                    <div>
                        <input type="checkbox" name="permissions[]" id="role-{{ $permission->id }}"
                            value="{{ $permission->name }}">
                        <label for="role-{{ $permission->id }}">{{ __($permission->name) }}</label>
                    </div>
                @endforeach
            </div>

            @foreach ($errors->get('generic') as $message)
                <p class="text-red-600">{{ $message }}</p>
            @endforeach

            <div class="pt-3 flex justify-end">
                <button class="bg-green-500 text-white rounded p-2 px-3" id="create">Aanmaken</button>
            </div>
        </div>
    </form>
    @push('scripts')
        <script>
            function toggleDialog(id) {
                let el = document.querySelector(id);
                el.open ? el.close() : el.showModal();
            }
        </script>
    @endpush
@endsection
