let isMoveInProgress = false;

function moveTemplate(pivotId, direction) {
    if (isMoveInProgress) {
        return;
    }

    isMoveInProgress = true;
    fetch('/admin/page/move-template', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        body: JSON.stringify({
            'page_id': document.querySelector('meta[name="page-id"]')
                .getAttribute('content'),
            'pivot_id': pivotId,
            'direction': direction
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.to_pivot) {
                const template = document.querySelector(`div[data-pivot-id="${pivotId}"]`);
                const toTemplate = document.querySelector(`div[data-pivot-id="${data.to_pivot}"]`);

                // switch template with toTemplate in dom
                const parent = template.parentNode;
                const next = template.nextSibling;

                parent.insertBefore(template, toTemplate);

                if (next) {
                    parent.insertBefore(toTemplate, next);
                } else {
                    parent.appendChild(toTemplate);
                }
            }

            isMoveInProgress = false;
        });
}

document.querySelectorAll('.move-button').forEach(button => {
    button.addEventListener('click', (e) => {
        moveTemplate(e.target.closest('.parent').dataset.pivotId, e.target.dataset.direction);
    });
});