@extends('layouts.admin')

@section('title', 'Sponsoren overzicht')

@section('pageTitle', 'Sponsoren')

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
                        Naam
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Link
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actief
                    </th>
                    <th scope="col" class="relative px-6 py-3 whitespace-nowrap text-right text-md font-medium">
                        <a href="{{ route('sponsors.create') }}" class="text-indigo-600 hover:text-indigo-900">
                            Nieuwe sponsor
                        </a>
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($sponsors as $sponsor)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $sponsor->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <a href="{{ route('page.show', $sponsor->page?->slug) }}"
                                    class="text-indigo-600 hover:text-indigo-900" target="_blank">
                                    {{ $sponsor->page ? '/' . $sponsor->page->slug : '...' }}
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div
                                class="text-sm text-gray-900 {{ $sponsor->page->isActive ? 'bg-green-400' : 'bg-red-400' }} px-2 w-10 rounded flex items-center justify-center">
                                {{ $sponsor->page->isActive ? 'Ja' : 'Nee' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('sponsors.edit', ['sponsor' => $sponsor->id]) }}"
                                class="text-indigo-600 hover:text-indigo-900">Wijzigen</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
