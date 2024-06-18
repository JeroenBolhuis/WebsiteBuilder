<dialog id="delete-dialog" class="p-4 rounded-lg shadow-2xl">
    <form id="delete-dialog-form" method="POST">
        @csrf
        @method('DELETE')
        <h1 class="text-3xl font-bold pb-2">Verwijderen?</h1>
        <p id="delete-dialog-message">Weet je zeker dat je dit item wilt verwijderen?</p>
        <div class="flex justify-end pt-2">
            <button type="button" class="bg-green-500 text-white rounded p-2 px-3 mr-2"
                onclick="toggleDialog('#delete-dialog')" autofocus>Terug</button>
            <button class="bg-red-500 text-white rounded p-2 px-3" id="deleteconfirm">Verwijderen</button>
        </div>
    </form>
</dialog>