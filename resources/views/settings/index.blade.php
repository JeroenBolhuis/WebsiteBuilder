@extends('layouts.admin')

@section('title', 'Instellingen')

@section('pageTitle', 'Instellingen')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 alert fade" role="alert">
            <span class="font-bold">Gelukt!</span>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden my-6">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th scope="col" colspan="2"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Kleur instellingen
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" class="px-6 py-4 whitespace-nowrap">
                    <form method="POST" action="{{ route('update-color') }}">
                        @csrf
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/2 px-2 mb-4">
                                <label for="primaryColor" class="block text-sm font-medium text-gray-700">
                                    Primaire kleur:
                                </label>
                                <input type="color" id="primaryColor" name="primaryColor"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    value="{{ old('primary_color') ?? $settings->primary_color }}">
                            </div>
                            <div class="w-full md:w-1/2 px-2 mb-4">
                                <label for="secondaryColor" class="block text-sm font-medium text-gray-700">
                                    Secondaire kleur:
                                </label>
                                <input type="color" id="secondaryColor" name="secondaryColor"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    value="{{ old('secondary_color') ?? $settings->secondary_color }}">
                            </div>
                        </div>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Opslaan
                        </button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden my-6">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th scope="col" colspan="2"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Favicon instellingen
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" class="px-6 py-4 whitespace-nowrap">
                    <form method="POST" action="{{ route('update-favicon') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/2 px-2 mb-4">
                                <div class="flex items-center">
                                    @if ($settings->favicon)
                                        <label for="favicon" class="block text-sm font-medium text-gray-700">
                                            Huidig Favicon:
                                        </label>

                                        <input type="hidden" name="old_favicon" value="{{ $settings->favicon }}">
                                        <img src="{{ asset('storage/' . $settings->favicon) }}" alt="Current Favicon"
                                            class="ml-2" width="32" height="32">
                                    @endif
                                </div>
                                <input type="file" id="favicon" name="favicon"
                                    accept=".ico"class="mt-1 block w-full sm:text-sm border-gray-300">
                            </div>
                        </div>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Opslaan
                        </button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="w-full bg-white shadow-md rounded-lg overflow-hidden my-6">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th scope="col" colspan="2"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Logo instellingen
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2" class="px-6 py-4 whitespace-nowrap">
                    <form method="POST" action="{{ route('update-logo') }}">
                        @csrf
                        <div class="flex flex-wrap -mx-2 w-full md:w-1/2 px-2 mb-4">
                            <x-media-chooser :mediaId="$settings->image_id" inputName="image_id" />
                        </div>
                        <div class="flex items-center justify-start mb-4">
                            <input type="checkbox" name="use_logo" id="use_logo"
                                value="{{ old('use_logo') ?? $settings->use_logo ? '1' : '0' }}"
                                {{ old('use_logo') ?? $settings->use_logo ? 'checked' : '' }}>
                            <label for="use_logo" class="text-sm font-medium text-gray-700 ml-2">Gebruik logo</label>
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Opslaan
                        </button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>

    <x-media-library-modal />
@endsection
