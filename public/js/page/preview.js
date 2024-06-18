
document.querySelector('.preview-button').addEventListener('click', function (e) {
    e.preventDefault();

    const templatesContainer = document.querySelector('.active-templates');
    const templates = templatesContainer.querySelectorAll('.parent');

    let inputData = {};

    templates.forEach((template, index) => {
        const pivotId = template.dataset.pivotId;
        const inputs = window.allTemplateInputs[pivotId];

        inputData[pivotId] = {};

        inputs.forEach(input => {
            const name = input;
            const inputField = template.querySelector(`[name="${input}"]`);

            if (inputField) {
                inputData[pivotId][name] = inputField.value;
            }
        });
    });

    fetch(this.dataset.url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            data: inputData
        })
    })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');

            return response.json();
        })
        .then(data => {
            window.open(data.url, '_blank');
        })
        .catch(error => {
            console.error(error);
            alert('Er is een fout opgetreden. Probeer het later opnieuw.');
        });
});
