let isMoveInProgress = false;

function getClosestMediaChooserParent(direction, mediaChooser) {
    const allParents = Array.from(document.querySelectorAll('div.media-inputs div.parent'));
    const currentIndex = allParents.indexOf(mediaChooser);

    if (currentIndex > 0 && direction == 'up') {
        return allParents[currentIndex - 1];
    } else if (currentIndex < allParents.length - 1 && direction == 'down') {
        return allParents[currentIndex + 1];
    } else {
        console.error(`No parent found ${direction}.`);
        return null;
    }
}

function moveTemplate(mediaChooser, direction) {
    if (isMoveInProgress) return;

    isMoveInProgress = true;

    const toMediaChooser = getClosestMediaChooserParent(direction, mediaChooser);
    if (toMediaChooser === null) {
        isMoveInProgress = false;
        return;
    }

    // Switch mediaChooser with toMediaChooser in the DOM
    const parent = mediaChooser.parentNode;
    const next = mediaChooser.nextSibling;

    parent.insertBefore(mediaChooser, toMediaChooser);

    if (next) {
        parent.insertBefore(toMediaChooser, next);
    } else {
        parent.appendChild(toMediaChooser);
    }

    isMoveInProgress = false;
}

function addEventListenerMoveButton() {
    document.querySelectorAll('.move-button').forEach(button => {
        button.addEventListener('click', (e) => moveTemplate(e.target.closest('.parent'), e.target.dataset.direction));
    });
}

function addEventListenerRemoveButton() {
    document.querySelectorAll('.remove-button').forEach(button => {
        button.addEventListener('click', (e) => e.target.closest('.parent').remove());
    });
}

function addEventListenerMediaChooser() {
    if (typeof addEventListenerOpenLibraryModal !== "undefined") {
        addEventListenerOpenLibraryModal();
    }
    addEventListenerMoveButton();
    addEventListenerRemoveButton();
}

addEventListenerMediaChooser();