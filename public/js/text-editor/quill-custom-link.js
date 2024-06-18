let Link = Quill.import('formats/link');

class CustomLink extends Link {
    static create(value) {
        const node = super.create(value);
        node.setAttribute('href', this.sanitize(value.url) ?? '');
        node.setAttribute('rel', 'noopener noreferrer');

        if (value.target) {
            node.setAttribute('target', value.target);
        }

        if (value.target) {
            node.setAttribute('title', value.title);
        }

        return node;
    }

    static formats(domNode) {
        return {
            url: domNode.getAttribute('href'),
            target: domNode.getAttribute('target'),
            title: domNode.getAttribute('title'),
            text: domNode.textContent,
        };
    }

    format(name, value) {
        if (name !== this.statics.blotName || !value) {
            super.format(name, value);
        } else if (name === 'url' && value) {
            this.domNode.setAttribute('href', value);
        } else if (name === 'target' && value) {
            this.domNode.setAttribute('target', value);
        } else if (name === 'title' && value) {
            this.domNode.setAttribute('title', value);
        } else if (name === 'text' && value) {
            this.domNode.textContent = value;
        } else {
            this.domNode.setAttribute('href', CustomLink.sanitize(value));
        }
    }
}

Quill.register('formats/link', CustomLink, true);

function quillCustomLink(editor) {
    let range = editor.getSelection();
    let selectedLink = null;

    if (range) {
        selectedLink = (editor.getLeaf(range.index)[0].domNode).parentNode.closest('a');
    }

    const modal = document.getElementById('customlink-dialog');
    let form = modal.querySelector('form');
    form.reset();
    form.replaceWith(form.cloneNode(true));
    form = modal.querySelector('form');

    if (selectedLink) {
        form.querySelector('input#customlink-text').value = selectedLink.textContent;
        form.querySelector('input#customlink-url').value = selectedLink.getAttribute('href');
        form.querySelector('input#customlink-title').value = selectedLink.getAttribute('title');

        form.querySelectorAll('select#customlink-target option').forEach(option => {
            if (option.value == selectedLink.getAttribute('target')) {
                option.selected = true;
            }
        });

        form.querySelectorAll('select#customlink-page option').forEach(option => {
            if (option.value == selectedLink.getAttribute('href')) {
                option.selected = true;
            }
        });
    } else {
        form.querySelector('input#customlink-text').value = editorGetSelectedText(editor);
    }

    form.querySelector('select#customlink-page').addEventListener('change', function (e) {
        form.querySelector('input#customlink-url').value = this.value;
        form.querySelector('input#customlink-text').value = e.target.options[e.target.selectedIndex].textContent;
    });

    form.querySelector('h3').textContent = selectedLink ? 'Update de link' : 'Maak een link';
    form.querySelector('button[type=submit]').textContent = selectedLink ? 'Update link' : 'Maak link';

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const submittedData = Object.fromEntries(new FormData(form).entries());

        const link = {
            text: submittedData['customlink-text'],
            url: submittedData['customlink-url'],
            title: submittedData['customlink-title'],
            target: submittedData['customlink-target']
        };

        if (selectedLink) {
            selectedLink.textContent = link.text;
            selectedLink.setAttribute('href', link.url);
            selectedLink.setAttribute('title', link.title);
            selectedLink.setAttribute('target', link.target);
        } else {
            if (!range) {
                editor.setSelection(editor.getLength() - 1, 0);
                range = editor.getSelection();

                editor.insertText(range.index, '\n');
                range = editor.getSelection();
            }

            editor.deleteText(range.index, range.length);
            editor.insertText(range.index, link.text, { link });
        }

        modal.close();
    });

    modal.showModal();
}

function editorGetSelectedText(editor) {
    const selection = editor.getSelection();
    if (selection) {
        return editor.getText(selection.index, selection.length);
    }
    return '';
}