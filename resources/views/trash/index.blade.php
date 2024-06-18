@extends('layouts.admin')
@section('title', 'Prullenbak')
@section('pageTitle', 'Prullenbak')

@section('content')
    @if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 alert fade" role="alert">
        <span class="font-bold">Gelukt!</span>
        <p>{{ session('success') }}</p>
    </div>
    @endif
    <div x-data="{ activeTab: 'tab1' }">
        <ul class="flex border-b">
            @foreach ($trashedModels as $key => $models)
                @can('edit ' . strtolower($key))
                    <li class="-mb-px mr-1 {{$key}}">
                        <a :class="activeTab === 'tab{{ $key }}' ?
                            'border-l border-t border-r rounded-t text-blue-700 font-semibold' :
                            'text-gray-500 hover:text-blue-800'"
                            class="bg-white inline-block py-2 px-4 font-semibold cursor-pointer"
                            @click="activeTab = 'tab{{ $key }}'">{{ __($key) }}</a>
                    </li>
                @endcan
            @endforeach
        </ul>

        <div class="p-4">
            @foreach ($trashedModels as $key => $models)
                @can('edit ' . strtolower($key))
                    @if ($models->count() == 0)
                        <div x-show="activeTab === 'tab{{ $key }}'">
                            <h2 class="text-xl font-semibold mb-4">{{ __($key) }}</h2>
                            <div class="bg-white shadow-md rounded-md p-4 mb-4">
                                <p class="text-gray-600">Geen verwijderde <span class="lowercase"> {{ __($key) }}</span> gevonden.</p>
                            </div>
                        </div>
                        @continue
                    @endif
                    <div x-show="activeTab === 'tab{{ $key }}'">
                        <h2 class="text-xl font-semibold mb-4">{{ __($key) }}</h2>

                        @foreach ($models as $model)
                            <div class="bg-white shadow-md rounded-md p-4 mb-4">
                                <h3 class="text-lg font-semibold mb-2">{{ $model->title ?? $model->name ?? $model->alt_text }}</h3>
                                <p class="text-sm text-gray-600 mb-2">Verwijderd op: {{ $model->deleted_at->format('d-m-Y H:i') }}</p>
                                    @if ($model->filename)
                                        <div class="flex items-center">
                                            <img class="w-32 h-auto" src="{{ $model->fullpath }}" alt="Image">
                                        </div>
                                    @endif
                                <div class="flex items-center">
                                    <form action="{{ route(strtolower($key) . '.restore', ['id' => $model->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="restore bg-green-500 text-white px-4 py-2 rounded-md mr-2">Herstellen</button>
                                    </form>
                                    <form action="{{ route(strtolower($key) . '.destroyPerm', ['id' => $model->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete bg-red-500 text-white px-4 py-2 rounded-md">Verwijderen</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endcan
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.cursor-pointer:first-child').click();
    });
</script>
@endpush

