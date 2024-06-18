let currentInput;

function addEventListenerOpenLibraryModal(selector = '.open-library-modal') {
  document.querySelectorAll(selector).forEach(element => {
    element.addEventListener('click', function (e) {
      currentInput = e.target.closest('.media-container').querySelector('input.media_id');
      medialib.showModal();
    });
  });
}

addEventListenerOpenLibraryModal();

function replaceElement(oldElement, newTagName) {
  const newElement = document.createElement(newTagName);
  newElement.className = oldElement.className;
  oldElement.parentNode.replaceChild(newElement, oldElement);
  return newElement;
}

function selectMedia(mediaId, filename, altText) {
  currentInput.value = mediaId;

  let previewMedia = currentInput.closest('.media-container').querySelector('.media-url');

  const isVideo = /\.mp4$/.test(filename);
  
  currentInput.dispatchEvent(Object.assign(new Event('change'), { isVideo }));

  // Set the correct tag based on the file type
  if (isVideo) {
    if (previewMedia.tagName === 'IMG') {
      previewMedia = replaceElement(previewMedia, 'video');
      previewMedia.controls = true;
    }
    previewMedia.title = altText;
  } else {
    if (previewMedia.tagName === 'VIDEO') {
      previewMedia = replaceElement(previewMedia, 'img');
    }
    previewMedia.alt = altText;
  }

  previewMedia.src = `/storage/media/${filename}`;

  medialib.close();
}

document.querySelector('.close-library-modal').addEventListener('click', function () {
  closeModal();
});

function closeModal() {
  currentInput = null;
  medialib.close();
}