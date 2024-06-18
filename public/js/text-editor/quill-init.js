function initTextEditors(selector) {
    const toolbarOptions = [
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }, { size: ['small', false, 'large', 'huge'] }],

        ['bold', 'italic', 'underline', 'strike', { 'align': [] }],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'list': 'check' }],

        ['link', 'blockquote'],

        [{ 'script': 'sub' }, { 'script': 'super' }],
        [{ 'indent': '-1' }, { 'indent': '+1' }, { 'direction': 'rtl' }],

        [{ 'color': [] }, { 'background': [] }],

        ['clean']
    ];

    class NoUploader {
        upload() { console.log('No uploader available'); }
    }

    Quill.register('modules/uploader', NoUploader, true);

    document.querySelectorAll(selector).forEach((element) => {
        const editor = new Quill(element, {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            }
        });

        const container = editor.container.parentNode.closest('.text-editor-container');
        const textarea = container.querySelector('textarea');

        const getEditorValue = () => {
            return editor.root.innerHTML;
        };

        const setEditorText = (newValue) => {
            editor.setText(newValue);
        };

        const setTextareaValue = (element) => {
            let editorValue = getEditorValue();
            if (editor.root.classList.contains('ql-blank')) { // Quill equivalent of being empty
                editorValue = '';
                setEditorText(editorValue);

                return element.value = editorValue;
            }

            return element.value = `<div class="ql-snow"><div class="ql-editor">${editorValue}</div></div>`;
        };

        setTextareaValue(textarea);

        editor.on('text-change', function () {
            setTextareaValue(textarea);
        });

        const oldButton = editor.getModule('toolbar').container.querySelector('.ql-formats .ql-link');
        const button = oldButton.cloneNode(true);

        button.addEventListener('click', quillCustomLink.bind(null, editor));

        oldButton.replaceWith(button);

        var toolbar = editor.container.previousSibling;
        toolbar.querySelector('span.ql-header').setAttribute('title', 'Header');
        toolbar.querySelector('span.ql-size').setAttribute('title', 'Size');
        
        toolbar.querySelector('button.ql-bold').setAttribute('title', 'Bold');
        toolbar.querySelector('button.ql-italic').setAttribute('title', 'Italic');
        toolbar.querySelector('button.ql-underline').setAttribute('title', 'Underline');
        toolbar.querySelector('button.ql-strike').setAttribute('title', 'Strike');
        toolbar.querySelector('span.ql-align').setAttribute('title', 'Align');

        toolbar.querySelector('button.ql-list[value=ordered]').setAttribute('title', 'Ordered list');
        toolbar.querySelector('button.ql-list[value=bullet]').setAttribute('title', 'Bullet list');
        toolbar.querySelector('button.ql-list[value=check]').setAttribute('title', 'Check list');

        toolbar.querySelector('button.ql-link').setAttribute('title', 'Link');
        toolbar.querySelector('button.ql-blockquote').setAttribute('title', 'Blockquote');

        toolbar.querySelector('button.ql-script[value=sub]').setAttribute('title', 'Subscript');
        toolbar.querySelector('button.ql-script[value=super]').setAttribute('title', 'Superscript');

        toolbar.querySelector('button.ql-indent[value=\'-1\']').setAttribute('title', 'Indent left');
        toolbar.querySelector('button.ql-indent[value=\'+1\']').setAttribute('title', 'Indent right');
        toolbar.querySelector('button.ql-direction[value=rtl]').setAttribute('title', 'Right to left');

        toolbar.querySelector('span.ql-color').setAttribute('title', 'Text color');
        toolbar.querySelector('span.ql-background').setAttribute('title', 'Background color');

        toolbar.querySelector('button.ql-clean').setAttribute('title', 'Clear Formatting');
    });
}

initTextEditors('.quill-editor');