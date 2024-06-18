let titleInput = document.querySelector('input[name=title]');

if(!titleInput) {
    titleInput = document.querySelector('input[name=name]');
}

const slugInput = document.querySelector('input[name=slug]');

titleInput.addEventListener('focusout', () => {
    if (slugInput.value == '') {
        let title = titleInput.value;

        title = title.trim().replace(/\W+/g, '-').toLowerCase();

        slugInput.value = title;
    }
});

slugInput.addEventListener('input', () => {
    slugInput.value = slugInput.value.replace(/\W+/g, '-').toLowerCase();
});