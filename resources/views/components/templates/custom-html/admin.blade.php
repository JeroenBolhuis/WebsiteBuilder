@props(['template'])

<div>
    <p>Schrijf of plak hieronder een stukje HTML wat vertoond moet worden in dit blok.</p>
    <textarea name="html" id="html" class="font-mono border rounded py-2 px-3 w-full">{{old('html', $template->pivot->data->html)}}</textarea>
    <p>
        Om Eventix te integreren, kunt u hierboven de integratiecode invoegen. 
        <a class="text-blue-500 underline" href="https://eventix.nl/help/integreer-ticketshop-website" target="_blank">Lees hier hoe u de integratiecode krijgt.</a>
    </p>
</div>