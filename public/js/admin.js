function alertFade() {
    setTimeout(function () {
        var alertElement = document.querySelector('.alert.fade');
        if (alertElement) {
            alertElement.style.transition = 'opacity 0.5s';
            alertElement.style.opacity = '0';
            setTimeout(function () {
                alertElement.remove();
            }, 500);
        }
    }, 3000);
}

alertFade();

function toggleDialog(id) {
    let el = document.querySelector(id);
    el.open ? el.close() : el.showModal();
}

function showDeleteDialog(itemName, actionUrl) {
    document.querySelector('#delete-dialog-message').textContent = `Weet je zeker dat je ${itemName} wilt verwijderen?`;
    document.querySelector('#delete-dialog-form').action = actionUrl;
    toggleDialog('#delete-dialog');
}

function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('hidden');
    sidebar.classList.toggle('flex');

    const toggleButton = document.querySelector('.fas.toggler');
    toggleButton.classList.toggle('fa-bars');
    toggleButton.classList.toggle('fa-times');
}

document.querySelectorAll('.accordion-button').forEach(btn => btn.addEventListener('click', () => btn.classList.toggle('open')));
