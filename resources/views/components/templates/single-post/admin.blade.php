@props(['template'])

<div>
    <label for="post" class="block text-sm font-bold text-gray-700 mb-2">Post</label>
    <select id="post" name="post_id" class="input-field border rounded-md px-4 py-2 w-full">
        <option value="">Selecteer een post</option>
        @foreach ($posts as $post)
            <option value="{{ $post->id }}" {{ $template->pivot->data->post_id == $post->id ? 'selected' : '' }}>
                {{ $post->title }}
            </option>
        @endforeach
    </select>
</div>
