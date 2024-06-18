@extends('layouts.admin')

@section('title', 'Logboek')

@section('pageTitle', 'Log Details')

@section('content')

    <div class="[&>p]:py-2 mb-4">
        <p>Gebruiker: {{ $log->user->name }}</p>
        <p>Actie: {{ $log->action . ' ' . $log->table_name }}</p>
        <p>Wanneer: {{ Carbon::parse($log->created_at)->locale('nl_NL')->isoFormat('D MMMM YYYY H:mm') }}</p>

        <p class="font-bold">Oude waardes:</p>
        <ul>
            @foreach (json_decode($log->old_values) as $key => $value)
                <li>
                    {{ $key . ': ' }}
                    @if (is_object($value) || is_array($value))
                        {{ json_encode($value) }}
                    @elseif (is_string($value) && strtotime($value))
                        {{ Carbon::parse($value)->locale('nl_NL')->isoFormat('D MMMM YYYY H:mm') }}
                    @elseif (is_string($value) && preg_match('/^<div class="ql-snow"><div class="ql-editor">/', $value))
                        <div class="bg-white p-4 my-2">
                            {!! $value !!}
                        </div>
                    @else
                        {{ $value }}
                    @endif
                </li>
            @endforeach
        </ul>

        <p class="font-bold">Nieuwe waardes:</p>
        <ul>
            @foreach (json_decode($log->new_values) as $key => $value)
                <li>
                    {{ $key . ': ' }}
                    @if (is_object($value) || is_array($value))
                        {{ json_encode($value) }}
                    @elseif (is_string($value) && strtotime($value))
                        {{ Carbon::parse($value)->locale('nl_NL')->isoFormat('D MMMM YYYY H:mm') }}
                    @elseif (is_string($value) && preg_match('/^<div class="ql-snow"><div class="ql-editor">/', $value))
                        <div class="bg-white p-4 my-2">
                            {!! $value !!}
                        </div>
                    @else
                        {{ $value }}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <a href="{{ route('admin.logbook') }}" class="underline text-blue-500">Terug</a>

@endsection
