@extends('layouts.admin')

@section('title', 'Evenementen')

@section('pageTitle', 'Evenementen')

@section('content')
    <div class="overflow-x-auto overflow-y-hidden">

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Titel
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Link
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actief
                    </th>
                    <th scope="col" class="px-6 py-3 whitespace-nowrap text-right text-md font-medium">
                        <a href="{{ route('event.create') }}" class="text-indigo-600 hover:text-indigo-900">
                            Nieuw evenement
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($events as $event)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $event->title }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <a href="{{ route('event.show', $event->slug) }}"
                                    class="text-indigo-600 hover:text-indigo-900" target="_blank">
                                    /evenementen/{{ $event->slug }}
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div
                                class="text-sm text-gray-900 {{ $event->isActive ? 'bg-green-400' : 'bg-red-400' }} px-2 w-10 rounded flex items-center justify-center">
                                {{ $event->isActive ? 'Ja' : 'Nee' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('event.edit', $event) }}" class="text-indigo-600 hover:text-indigo-900">
                                Wijzigen
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
