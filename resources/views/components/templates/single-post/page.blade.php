@props(['template'])

@if ($post)
    <div class="flex justify-center">
        <div class="flex flex-col max-w-[486px] w-full [&>div:last-child]:border-b-0">
            <x-post-feed-item :post="$post" />
        </div>
    </div>
@endif
