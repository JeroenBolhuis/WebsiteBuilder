<div>
    <div class="mb-4 flex items-center gap-4">
        <span class="text-sm font-medium text-gray-700 mr-2">Filter:</span>

        <div>
            <input type="checkbox" id="active-filter" value="{{ true }}" wire:model.live="activeFilter">
            <label for="active-filter">Actief</label>
        </div>
        <div>
            <input type="checkbox" id="not-active-filter" value="{{ false }}" wire:model.live="activeFilter">
            <label for="not-active-filter">Niet actief</label>
        </div>
    </div>

    <div class="overflow-x-auto overflow-y-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Landingspagina
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Titel
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Link
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actief
                    </th>
                    <th scope="col" class="relative px-6 py-3 whitespace-nowrap text-right text-md font-medium">
                        <a href="{{ route('page.create') }}" class="text-indigo-600 hover:text-indigo-900">
                            Nieuwe pagina
                        </a>
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($pages as $page)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap w-[0.1%]">
                            <div>
                                <input type="radio" name="isHomepage" class="homepage-selector cursor-pointer"
                                    data-page-id="{{ $page->id }}" {{ $page->isHomepage ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $page->title }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <a href="{{ route('page.show', $page->slug) }}"
                                    class="text-indigo-600 hover:text-indigo-900" target="_blank">
                                    /{{ $page->slug }}
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div
                                class="text-sm text-gray-900 {{ $page->isActive ? 'bg-green-400' : 'bg-red-400' }} px-2 w-10 rounded flex items-center justify-center">
                                {{ $page->isActive ? 'Ja' : 'Nee' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('page.edit', ['page' => $page->id]) }}"
                                class="text-indigo-600 hover:text-indigo-900">Wijzigen</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
