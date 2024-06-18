const isHomepageRadio = document.querySelectorAll('input[name=isHomepage]');

isHomepageRadio.forEach((radio) => {
    radio.addEventListener('change', function () {
        if (this.checked) {
            fetch('/admin/page/set-homepage/' + this.dataset.pageId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                }
            })
                .then((response) => response.json())
                .then((data) => {
                    // Refresh de pagina na 2 seconden
                    setTimeout(() => {
                        location.reload();
                    }, 2000);

                    // Toon een succesbericht
                    const succesAlert = `<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 alert fade" role="alert">
                        <span class="font-bold">Gelukt!</span>
                        <p>` + data.message + `</p>
                    </div>`;

                    document.querySelector('.container').insertAdjacentHTML('afterbegin',
                        succesAlert);
                });
        }
    });
});