document.querySelector('.preview-button').addEventListener('click', function (e) {
    e.preventDefault();

    const form = document.querySelector('form.event-form');
    let inputData = {};

    form.querySelectorAll('input[name], select[name], textarea[name]').forEach(input => {
        if (input.type === 'checkbox') {
            inputData[input.name] = input.checked ? input.value : null;
        } else {
            inputData[input.name] = input.value;
        }
    });

    const exceptions = ['_token', '_method'];

    exceptions.forEach(exception => {
        delete inputData[exception];
    });

    fetch(this.dataset.url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            ...inputData
        })
    })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');

            return response.json();
        })
        .then(data => {
            form.querySelectorAll('.text-red-600').forEach(el => el.remove());

            if (data.errors) {
                Object.keys(data.errors).forEach(key => {
                    const inputParent = form.querySelector(`[name="${key}"]`).parentElement;

                    inputParent.insertAdjacentHTML('beforeend', `<p class="text-red-600">${data.errors[key].join(' ')}</p>`);
                });

                return;
            }

            window.open(data.url, '_blank');
        })
        .catch(error => {
            console.error(error);
            alert('Er is een fout opgetreden. Probeer het later opnieuw.');
        });
});
