<div>
    <div class="modal-box">
        <h3 class="font-bold text-lg">Kies media</h3>
        {{-- Tabbed navigation --}}
        <div class="flex mb-4 [&>a]:cursor-pointer">
            <a class="mr-2 px-4 py-2 bg-blue-500 text-white rounded-tl rounded-bl" wire:click="switchTab()"
                tabindex="0">Mediabibliotheek</a>
            <a class="px-4 py-2 bg-blue-500 text-white rounded-tr rounded-br" wire:click="switchTab()"
                tabindex="0">Upload</a>
        </div>

        {{-- Media library tab content --}}
        <div id="mediaLibraryTab" class="tab-content {{ $openTab === 'library' ? '' : 'hidden' }}">
            <div class="mb-4 flex gap-4">
                <div>
                    <input type="checkbox" id="imageFilter" value="image" wire:model.live="typeFilter">
                    <label for="imageFilter">Afbeeldingen</label>
                </div>
                <div>
                    <input type="checkbox" id="videoFilter" value="video" wire:model.live="typeFilter">
                    <label for="videoFilter">Video's</label>
                </div>
            </div>

            <div
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-8 gap-y-4 mb-4 items-baseline my-3 [&>div]:cursor-pointer">
                @foreach ($allMedia as $media)
                    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden .select-media" tabindex="0"
                        onclick="selectMedia('{{ $media->id }}', '{{ $media->filename }}', '{{ urlencode($media->alt_text) }}')"
                        onkeydown="if(event.key === 'Enter' || event.key === ' ') { this.click(); }">

                        <x-media :media="$media" class="w-full h-32 object-contain" muted />

                        <div class="p-4">
                            <p class="text-lg font-semibold">{{ $media->alt_text }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $allMedia->links() }}
            </div>
        </div>

        {{-- Upload tab content --}}
        <div id="uploadTab" class="tab-content {{ $openTab === 'upload' ? '' : 'hidden' }}">
            <form id="mediaUploadForm" enctype="multipart/form-data" wire:submit="mediaUpload" class="max-w-md mx-auto">
                <div class="mb-4">
                    @if ($uploadMedia && in_array($uploadMedia->getClientOriginalExtension(), $supportedMimes))
                        @if (strpos($uploadMedia->getMimeType(), 'video/mp4') !== false)
                            <video src="{{ $uploadMedia->temporaryUrl() }}" controls class="mb-2"></video>
                        @else
                            <img src="{{ $uploadMedia->temporaryUrl() }}" class="mb-2">
                        @endif
                    @endif

                    <label for="uploadMedia" class="block text-gray-700 text-sm font-bold mb-2">Media:</label>
                    <input type="file" wire:model="uploadMedia" value="{{ old('uploadMedia') }}"
                        accept="image/png, image/jpg, image/jpeg, image/svg, image/gif, video/mp4" name="uploadMedia"
                        id="uploadMedia" class="border rounded py-2 px-3 w-full" required>

                    @error('uploadMedia')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="alt" class="block text-gray-700 text-sm font-bold mb-2">Omschrijving:</label>
                    <input type="text" wire:model="alt_text" name="alt_text" id="alt"
                        value="{{ old('alt_text') }}" class="border rounded py-2 px-3 w-full">
                    @error('alt_text')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div wire:loading.remove wire:target="uploadMedia">
                    <button type="submit" id="upload"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Upload & kiezen
                    </button>
                </div>

                <div wire:loading wire:target="uploadMedia" class="font-bold py-2 px-4">Bezig met uploaden...</div>

            </form>
        </div>
        <div class="modal-action">
            <button onclick="closeModal()"
                class="btn bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded close-library-modal">
                Sluiten
            </button>
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('selectMedia', (params) => {
            selectMedia(params.mediaId, params.filename, params.altText)
            closeModal();
        });
    </script>
@endscript

@push('scripts')
    <script src="{{ asset('js/medialibrary.js') }}"></script>
@endpush
