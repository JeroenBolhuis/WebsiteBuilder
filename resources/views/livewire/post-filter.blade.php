<div>
    <div class="flex items-center mb-4">
        <span class="text-sm font-medium text-gray-700 mr-2">Filter:</span>
        <label class="inline-flex items-center mr-4">
            <input type="checkbox" wire:model.live="isSent" class="mr-1">
            Ingezonden
        </label>
        <label class="inline-flex items-center mr-4">
            <input type="checkbox" wire:model.live="isActive" class="mr-1">
            Actief
        </label>
        <label class="inline-flex items-center">
            <input type="checkbox" wire:model.live="isAccepted" class="mr-1">
            Geaccepteerd
        </label>
        <select wire:model.live="sortBy" class="rounded-md border border-gray-300 shadow-sm py-1 ml-2 px-2">
            <option value="created_at_desc">Nieuw naar oud</option>
            <option value="created_at_asc">Oud naar nieuw</option>
        </select>

        <select wire:model.live="category" class="rounded-md border border-gray-300 shadow-sm py-1 ml-2 px-2">
            <option value="">Alle categorieën</option>
            <option value="null">Geen categorie</option>
            @foreach ($postCategories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <button id="create-category-button" onclick="toggleDialog('#create-category')"
            class="text-indigo-600 hover:text-indigo-900 ml-auto cursor-pointer">Categorie toevoegen</button>

    </div>

    <div class="overflow-x-auto overflow-y-hidden">

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Titel
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Datum
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actief
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Ingezonden
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Geaccepteerd
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Categorie
                    </th>
                    <th scope="col" class="relative px-6 py-3 whitespace-nowrap text-right text-md font-medium">
                        <a href="{{ route('post.create') }}" class="text-indigo-600 hover:text-indigo-900">
                            Nieuwe post
                        </a>
                    </th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($posts as $post)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $post->title }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $post->created_at->format('d-m-Y H:i') }}
                            </div>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div
                                class="text-sm text-gray-900 {{ $post->isActive ? 'bg-green-400' : 'bg-red-400' }} px-2 w-10 rounded flex items-center justify-center">
                                {{ $post->isActive ? 'Ja' : 'Nee' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div
                                class="text-sm text-gray-900 {{ $post->isSent ? 'bg-green-400' : 'bg-red-400' }} px-2 w-10 rounded flex items-center justify-center">
                                {{ $post->isSent ? 'Ja' : 'Nee' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div
                                class="text-sm text-gray-900 {{ $post->isAccepted ? 'bg-green-400' : 'bg-red-400' }} px-2 w-10 rounded flex items-center justify-center">
                                {{ $post->isAccepted ? 'Ja' : 'Nee' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-90 px-2 w-10 rounded flex items-center justify-center">
                                {{ $post->postCategory ? $post->postCategory->name : 'Geen categorie' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if (!$post->isAccepted && $post->isSent)
                                <a href="{{ route('post.showSent', ['post' => $post]) }}"
                                    class="text-indigo-600 hover:text-indigo-900">Bekijken</a>
                            @else
                                <a href="{{ route('post.edit', ['post' => $post]) }}"
                                    class="text-indigo-600 hover:text-indigo-900">Wijzigen</a>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>

    <dialog id="create-category" class="w-[1500px] overflow-y-auto p-8 rounded">
        <h2 class="text-xl font-semibold mb-4">Post categorie toevoegen</h2>
        <form action="{{ route('post-category.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Naam</label>
                <input type="text" name="name" id="name"
                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm">
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="toggleDialog('#create-category')"
                    class="px-4 py-2 mr-2 bg-gray-200 text-gray-700 rounded close">Annuleren</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Opslaan</button>
            </div>
        </form>

        <h2 class="text-xl font-semibold mb-4">Post categorie bijwerken</h2>
        @foreach ($postCategories as $category)
            <form action="{{ route('post-category.update', ['post_category' => $category]) }}" method="POST">
                @csrf
                @method('PUT')
                <li class="flex items-center justify-between mb-2">
                    <div>
                        <input type="text" name="name" value="{{ $category->name }}"
                            class="mt-1 p-2 block w-full rounded-md border-black-300 shadow-lg focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm">
                    </div>
                    <div>
                        <button type="submit" class="text-indigo-600 hover:text-indigo-900">Opslaan</button>
                    </div>
                </li>
            </form>
        @endforeach
    </dialog>
</div>
