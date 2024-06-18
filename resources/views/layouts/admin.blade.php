<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(config('app.env') === 'production')
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    
    @stack('meta')

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Favicon -->
    @php
        $faviconUrl = asset('storage/' . $settings->favicon);
    @endphp
    <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @livewireStyles
    @stack('styles')

    <!-- Scripts -->
    <script src="{{ asset('js/tailwind.js') }}"></script>
    <script type="module" src="{{ asset('js/tailwindconfig.js') }}"></script>
    <x-head.text-editor-config />
</head>

<body class="font-sans antialiased">
    <div class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        <div class="sidebar hidden md:flex flex-shrink-0">
            <div class="flex flex-col w-64">
                <div class="flex flex-col h-0 flex-1 bg-gray-900">
                    <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-800 text-white font-normal text-2xl">
                        {{ config('app.name') }}
                    </div>
                    <div class="flex-1 flex flex-col overflow-y-auto">
                        <nav class="flex-1 px-2 py-4 bg-gray-800 space-y-1">
                            @can('edit page')
                                <a href="{{ route('page.index') }}"
                                    class="{{ strpos(Route::currentRouteName(), 'page') === 0 ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                    <i
                                        class="flex items-center justify-center fas fa-file-alt mr-3 flex-shrink-0 h-6 w-6 {{ strpos(Route::currentRouteName(), 'page') === 0 ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                                    Pagina's
                                </a>
                            @endcan

                            @can('edit event')
                                <a href="{{ route('event.index') }}"
                                    class="{{ strpos(Route::currentRouteName(), 'event') === 0 ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                    <i
                                        class="flex items-center justify-center fas fa-calendar-alt mr-3 flex-shrink-0 h-6 w-6 {{ strpos(Route::currentRouteName(), 'fake.evenementen') === 0 ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                                    Evenementen
                                </a>
                            @endcan

                            @can('edit sponsor')
                                <a href="{{ route('sponsors.index') }}"
                                    class="{{ strpos(Route::currentRouteName(), 'sponsor') === 0 ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                    <i
                                        class="flex items-center justify-center fas fa-handshake mr-3 flex-shrink-0 h-6 w-6 {{ strpos(Route::currentRouteName(), 'sponsor') === 0 ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                                    Sponsoren
                                </a>
                            @endcan

                            @can('edit post')
                                <a href="{{ route('post.index') }}"
                                    class="{{ strpos(Route::currentRouteName(), 'post') === 0 ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                    <i
                                        class="flex items-center justify-center fas fa-newspaper mr-3 flex-shrink-0 h-6 w-6 {{ strpos(Route::currentRouteName(), 'post') === 0 ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                                    Posts
                                </a>
                            @endcan

                            @can('edit nav')
                                <a href="{{ route('nav.index') }}"
                                    class="{{ strpos(Route::currentRouteName(), 'nav') === 0 ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                    <i
                                        class="flex items-center justify-center fas fa-list mr-3 flex-shrink-0 h-6 w-6 {{ strpos(Route::currentRouteName(), 'nav') === 0 ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                                    Navigatiebalk
                                </a>
                            @endcan

                            @can('edit media')
                                <a href="{{ route('media.index') }}"
                                    class="{{ strpos(Route::currentRouteName(), 'media') === 0 ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                    <i
                                        class="flex items-center justify-center fas fa-images mr-3 flex-shrink-0 h-6 w-6 {{ strpos(Route::currentRouteName(), 'auth.register') === 0 ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                                    Mediabibliotheek
                                </a>
                            @endcan

                            @can('edit album')
                                <a href="{{ route('album.index') }}"
                                    class="{{ strpos(Route::currentRouteName(), 'album') === 0 ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                    <i
                                        class="flex items-center justify-center fas fa-folder mr-3 flex-shrink-0 h-6 w-6 {{ strpos(Route::currentRouteName(), 'fake.albums') === 0 ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                                    Albums
                                </a>
                            @endcan

                            @can('edit user')
                                <a href="{{ route('user.index') }}"
                                    class="{{ strpos(Route::currentRouteName(), 'user') === 0 ? 'text-white bg-gray-900' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                    <i
                                        class="flex items-center justify-center fas fa-user mr-3 flex-shrink-0 h-6 w-6 {{ strpos(Route::currentRouteName(), 'user') === 0 ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                                    Gebruikers
                                </a>
                            @endcan

                            @can('edit footer')
                                <a href="{{ route('footer.index') }}"
                                    class="{{ strpos(Route::currentRouteName(), 'footer.index') === 0 ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                    <i
                                        class="flex items-center justify-center fas fa-arrow-down mr-3 flex-shrink-0 h-6 w-6 {{ strpos(Route::currentRouteName(), 'footer.index') === 0 ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                                    Footer
                                </a>
                            @endcan

                            @can('edit settings')
                                <a href="{{ route('admin.settings') }}"
                                    class="{{ strpos(Route::currentRouteName(), 'admin.settings') === 0 ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                    <i
                                        class="flex items-center justify-center fas fa-gear mr-3 flex-shrink-0 h-6 w-6 {{ strpos(Route::currentRouteName(), 'admin.settings') === 0 ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                                    Instellingen
                                </a>
                            @endcan

                            @can('see log')
                                <a href="{{ route('admin.logbook') }}"
                                    class="{{ strpos(Route::currentRouteName(), 'admin.logbook') === 0 ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                    <i
                                        class="flex items-center justify-center fas fa-clipboard mr-3 flex-shrink-0 h-6 w-6 {{ strpos(Route::currentRouteName(), 'admin.logbook') === 0 ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                                    Logboek
                                </a>
                            @endcan

                            @if (SoftDeletedHelper::hasPermission())
                                <a href="{{ route('trash.index') }}"
                                    class="{{ strpos(Route::currentRouteName(), 'trash.index') === 0 ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                    <i
                                        class="flex items-center justify-center fas fa-trash mr-3 flex-shrink-0 h-6 w-6 {{ strpos(Route::currentRouteName(), 'admin.trash') === 0 ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300' }}"></i>
                                    Prullenbak
                                </a>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <button
                    class="px-4 border-r border-gray-200 text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden"
                    onclick="toggleSidebar()">
                    <span class="sr-only">Open sidebar</span>
                    <i class="toggler fas fa-bars h-6 w-6"></i>
                </button>
                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex">
                    </div>
                    <div class="ml-4 flex items-center md:ml-6">
                        <form class="ml-3 relative" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                                id="user-menu-item-2">Uitloggen</a>
                        </form>
                    </div>
                </div>
            </div>

            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <div class="container max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mt-10">
                        <h1 class="text-2xl font-semibold text-gray-900 mb-6">@yield('pageTitle')</h1>
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
    <script src="{{ asset('js/admin.js') }}"></script>
    @stack('scripts')
</body>

</html>
