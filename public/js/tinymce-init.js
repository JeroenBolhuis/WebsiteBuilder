function initTinyMCE(selector) {
    tinymce.init({
        selector: selector,
        plugins: 'paste,link,textcolor',
        menubar: false,
        paste_data_images: false,
        paste_as_text: true,
        smart_paste: false,
        toolbar: 'undo redo | formatselect | bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | forecolor | link unlink |',
        link_list: window.link_list,
    });
}

function destroyTinyMCE(selector) {
    document.querySelectorAll(selector).forEach((element) => {
        var editor = tinymce.get(element.id);
        if (editor) {
            editor.remove();
        }
    });
}

function reInitTinyMCE(selector) {
    destroyTinyMCE(selector);
    initTinyMCE(selector);
}

initTinyMCE('.tinyeditor');