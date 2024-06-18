import { updateLinkedPages } from './update-linked-pages.js';

function removeTemplate(pivotId) {
    fetch('/admin/page/remove-template', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        body: JSON.stringify({
            'pivot_id': pivotId,
            'page_id': document.querySelector('meta[name="page-id"]')
            .getAttribute('content'),
        })
    })
        .then(response => response.json())
        .then(data => {
            let div = document.querySelector(`div[data-pivot-id="${pivotId}"]`);
            div.parentNode.removeChild(div);

            if(data.status === 'error')
                return;
    })
        .then(() => {
        updateLinkedPages();
    });
}
const removeButtons = document.querySelectorAll('.remove-button');

removeButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        removeTemplate(e.target.closest('.parent').dataset.pivotId);
    });
});