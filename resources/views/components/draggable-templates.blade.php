<div>
    @foreach ($categories as $category)
        @if ($category->templates->isNotEmpty())
            <button type="button"
                class="flex items-center w-full p-5 border border-gray-200 rounded-md focus:ring-4 focus:ring-gray-200 hover:bg-gray-100 accordion-button"
                data-accordion-target=".accordion-{{ $category->id }}">
                <h3 class="text-xl">{{ $category->name }}</h3>
                <i class="fas fa-arrow-up ml-auto mr-4"></i>
            </button>
            <div class="accordion-body accordion-{{ $category->id }} mt-4 mb-4">
                @foreach ($category->templates as $template)
                    <div id="template-{{ $template->id }}" data-template-id="{{ $template->id }}"
                        class="flex items-center gap-4 bg-white shadow-md rounded px-4 pt-3 pb-3 border-b mt-2 hover:bg-gray-100 cursor-pointer transition-colors"
                        draggable="true">
                        <div class="grow">
                            <p class="font-bold break-words">{{ __($template->name) }}</p>
                            <p class="text-sm leading-4">{{ $template->description }}</p>
                        </div>

                        <button
                            class="px-2 bg-gray-100 rounded hover:bg-gray-200 transition-colors border aspect-square"
                            onclick="addTemplateToPage({{ $template->id }})">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach
</div>
