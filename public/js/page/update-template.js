import { updateLinkedPages } from './update-linked-pages.js';

document.querySelectorAll('.update-template').forEach(function (form) {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let data = new FormData(form);

        fetch(form.getAttribute('action'), {
            method: form.getAttribute('method'),
            body: data
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const alert = `
                <div class="bg-green-100 border border-green-400 text-green-700 my-4 px-4 py-3 rounded relative alert fade">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm leading-5 font-medium">Success!</p>
                            <p class="text-sm leading-5">${data.message}</p>
                        </div>
                    </div>
                </div>`;

                    form.closest('.template-container').insertAdjacentHTML('beforebegin', alert);
                    alertFade();
                }
            })
            .then(() => {
                updateLinkedPages();
            });
    });
});