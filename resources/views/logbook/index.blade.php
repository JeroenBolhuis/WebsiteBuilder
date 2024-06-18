@extends('layouts.admin')

@section('title', 'Logboek')

@section('pageTitle', 'Logboek')

@section('content')

    @if (!auth()->user()->favoriteLogs->isEmpty())
        <h2 class="text-xl font-bold mb-4">Favoriete Logs</h2>

        <div class="overflow-x-auto overflow-y-hidden">
            <table class="table-auto mb-8">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-4 py-2"></th>
                        <th class="px-4 py-2">Wie</th>
                        <th class="px-4 py-2">Wat</th>
                        <th class="px-4 py-2">Wanneer</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (auth()->user()->favoriteLogs as $favoriteLog)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2 text-gray-700">
                                <form action="{{ route('admin.logbook.favorite', $favoriteLog) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-yellow-500"><i class="fa-solid fa-star"></i></button>
                                </form>
                            </td>
                            <td class="px-4 py-2 text-gray-700">{{ $favoriteLog->user->name }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $favoriteLog->action . ' ' . $favoriteLog->table_name }}
                            </td>
                            <td class="px-4 py-2 text-gray-700">
                                {{ Carbon::parse($favoriteLog->created_at)->locale('nl_NL')->isoFormat('D MMMM YYYY H:mm') }}
                            </td>
                            <td class="px-4 py-2 text-gray-700"><a href="{{ route('admin.logbook.show', $favoriteLog) }}"
                                    class="underline text-blue-500" dusk="bekijk">Bekijk</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <h2 class="text-xl font-bold mb-4">Alle Logs</h2>

    <div class="overflow-x-auto overflow-y-hidden">
        <table class="table-auto">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="px-4 py-2"></th>
                    <th class="px-4 py-2">Wie</th>
                    <th class="px-4 py-2">Wat</th>
                    <th class="px-4 py-2">Wanneer</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2 text-gray-700">
                            <form action="{{ route('admin.logbook.favorite', $log) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-yellow-500">
                                    <i
                                        class="fa-{{ auth()->user()->favoriteLogs->contains($log) ? 'solid' : 'regular' }} fa-star"></i>
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-2 text-gray-700">{{ $log->user->name }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $log->action . ' ' . $log->table_name }}</td>
                        <td class="px-4 py-2 text-gray-700">
                            {{ Carbon::parse($log->created_at)->locale('nl_NL')->isoFormat('D MMMM YYYY H:mm') }}</td>
                        <td class="px-4 py-2 text-gray-700"><a href="{{ route('admin.logbook.show', $log) }}"
                                class="underline text-blue-500" dusk="bekijk">Bekijk</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>
@endsection
