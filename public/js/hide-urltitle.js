document.querySelectorAll('.media_link-container').forEach(mediaLinkContainer => {
    const toggleElement = (isVideo) => {
        if (isVideo) {
            mediaLinkContainer.classList.add('hidden');
            mediaLinkContainer.querySelectorAll('input').forEach(input => input.value = '');
        } else {
            mediaLinkContainer.classList.remove('hidden');
        }
    };

    const parent = mediaLinkContainer.closest('*:has(input.media_id)');

    // On page load
    if (parent.querySelector('.media-url').tagName === 'VIDEO') toggleElement(true);

    // On media change
    parent.querySelector('input.media_id').addEventListener('change', event => toggleElement(event.isVideo));

    mediaLinkContainer.querySelector('.media_url').addEventListener('input', function () {
        const mediaTitleContainer = mediaLinkContainer.querySelector('.media_title_container');

        if (this.value.trim() !== '') {
            mediaTitleContainer.classList.remove('hidden');
        } else {
            mediaTitleContainer.classList.add('hidden');
            mediaTitleContainer.querySelector('input[name=media_title]').value = '';
        }
    });
});