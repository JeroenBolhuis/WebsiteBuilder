@extends('layouts.admin')
@section('title', 'Gebruikers')
@section('pageTitle', 'Gebruikers')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 alert fade" role="alert">
            <span class="font-bold">Gelukt!</span>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-x-auto overflow-y-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Gebruikersnaam
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        E-mail
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Rechten
                    </th>
                    <th scope="col" class="relative px-6 py-3 whitespace-nowrap text-right text-md font-medium">
                        <a href="{{ route('user.create') }}" id="new-user" class="text-indigo-600 hover:text-indigo-900">
                            Nieuwe gebruiker
                        </a>
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $user->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $user->email }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $allRoles = '';
                                foreach ($user->permissions as $permission) {
                                    $allRoles =
                                        $allRoles .
                                        ($permission != $user->permissions[0] ? ', ' : '') .
                                        __($permission->name);
                                }
                            @endphp
                            <div class="text-sm text-gray-900" title="{{ $allRoles }}">
                                {{ $allRoles }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('user.edit', ['user' => $user]) }}"
                                class="text-indigo-600 hover:text-indigo-900">Bewerken</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
@endsection
