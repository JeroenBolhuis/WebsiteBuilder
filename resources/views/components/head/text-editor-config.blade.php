@push('scripts')
    <dialog id="customlink-dialog" class="z-[999] h-screen w-screen bg-black bg-opacity-0 outline-none">
        <div class="w-full h-full flex items-center justify-center">
            <div
                class="relative flex w-full p-8 max-w-[24rem] flex-col rounded-xl bg-white text-gray-700 shadow-md items-center justify-center">
                <button type="button" class="absolute top-8 right-8 text-gray-500 hover:text-gray-700"
                    onclick="toggleDialog('#customlink-dialog')">
                    <i class="fas fa-times text-xl"></i>
                </button>
                <form class="w-full">
                    <h3 class="text-lg mb-4">Maak een link</h3>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="customlink-page">Pagina</label>
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                            id="customlink-page" name="customlink-page">
                            <option value="">Geen</option>
                            @foreach ($pages as $index => $pageGroup)
                                <optgroup label="{{ $index ? 'Normale pagina\'s' : 'Andere pagina\'s' }} ">
                                    @foreach ($pageGroup as $page)
                                        <option value="{{ route('page.show', $page->slug) }}">{{ $page->title }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-400">
                            Dit vult automatisch de text en URL in voor de gekozen pagina.
                        </p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="customlink-text">Text *</label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                            id="customlink-text" name="customlink-text" type="text" placeholder="Link tekst">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="customlink-url">URL *</label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                            id="customlink-url" name="customlink-url" type="url" placeholder="https://google.nl/">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="customlink-title">Title</label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                            id="customlink-title" name="customlink-title" type="text" placeholder="Link titel">
                        <p class="mt-1 text-xs text-gray-400">
                            De title wordt laten zien bij het hoveren over de link.
                        </p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="customlink-target">Target</label>
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                            id="customlink-target" name="customlink-target">
                            <option value="_self">Huidige tabblad</option>
                            <option value="_blank">Nieuwe tabblad</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <button type="button" onclick="toggleDialog('#customlink-dialog')"
                            class="inline text-sm font-medium text-red-500 hover:text-red-700">
                            Sluit venster
                        </button>
                        <button type="submit"
                            class="ml-auto inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Maak Link
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </dialog>

    <script src="{{ asset('js/text-editor/quill.js') }}"></script>
    <script src="{{ asset('js/text-editor/quill-custom-link.js') }}"></script>
    <script src="{{ asset('js/text-editor/quill-init.js') }}"></script>
@endpush
