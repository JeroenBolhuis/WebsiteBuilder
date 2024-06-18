@extends('layouts.admin')

@section('title', 'Navigatiebalk bewerken')

@section('pageTitle', 'Navigatiebalk bewerken')

@section('content')
    <div class="overflow-x-auto overflow-y-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Naam
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Bestemming
                    </th>
                    <th scope="col" class="relative px-6 py-3 whitespace-nowrap text-right text-md font-medium">
                        <a href="{{ route('nav.create') }}" class="text-indigo-600 hover:text-indigo-900">Nieuw nav item</a>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 hide-order-arrows">
                @foreach ($navItems->where('parent_id', null) as $navItem)
                    <tr class="parent-nav">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">
                                {{ $navItem->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap max-w-[200px]">
                            <div class="text-sm text-gray-900 overflow-hidden">
                                @if ($navItem->url)
                                    <a href="{{ $navItem->url }}" target="_blank">
                                        <p class="text-blue-500 hover:text-blue-700 truncate">{{ $navItem->url }}</p>
                                    </a>
                                @else
                                    <span
                                        class="truncate">{{ $navItem->page ? $navItem->page->title : 'Geen bestemming' }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex gap-2 p-2 justify-end">
                                @if (!$loop->first)
                                    <form method="POST" action="{{ route('nav.moveNavItem') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $navItem->id }}">
                                        <input type="hidden" name="direction" value="up">
                                        <button type="submit" class="move-button">
                                            <i class="fas fa-arrow-up"></i>
                                        </button>
                                    </form>
                                @endif
                                @if (!$loop->last)
                                    <form method="POST" action="{{ route('nav.moveNavItem') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $navItem->id }}">
                                        <input type="hidden" name="direction" value="down">
                                        <button type="submit" class="move-button">
                                            <i class="fas fa-arrow-down"></i>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('nav.create', ['id' => $navItem->id]) }}" class="add-button ml-20">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                                <a href="{{ route('nav.edit', ['navItem' => $navItem->id]) }}" class="edit-button">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @foreach ($navItems->where('parent_id', $navItem->id) as $childItem)
                        <tr class="child-nav">
                            <td class="pl-12 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $childItem->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap max-w-[200px]">
                                <div class="text-sm text-gray-900 overflow-hidden">
                                    @if ($childItem->url)
                                        <a href="{{ $childItem->url }}" target="_blank">
                                            <p class="text-blue-500 hover:text-blue-700 truncate">
                                                {{ $childItem->url }}</p>
                                        </a>
                                    @else
                                        <span
                                            class="truncate">{{ $childItem->page ? $childItem->page->title : 'Geen bestemming' }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex gap-2 p-2 justify-end">
                                    @if (!$loop->first)
                                        <form method="POST" action="{{ route('nav.moveNavItem') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $childItem->id }}">
                                            <input type="hidden" name="direction" value="up">
                                            <button type="submit" class="move-button">
                                                <i class="fas fa-arrow-up"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if (!$loop->last)
                                        <form method="POST" action="{{ route('nav.moveNavItem') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $childItem->id }}">
                                            <input type="hidden" name="direction" value="down">
                                            <button type="submit" class="move-button">
                                                <i class="fas fa-arrow-down"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a class="add-button opacity-0 ml-20">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                    <a href="{{ route('nav.edit', ['navItem' => $childItem->id]) }}" class="edit-button">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
