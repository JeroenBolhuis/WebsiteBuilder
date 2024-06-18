export function updateLinkedPages() {
    var pageId = document.querySelector('meta[name="page-id"]').getAttribute('content');

    var url = '/admin/page/' + pageId + '/linked-pages';

    fetch(url)
        .then(response => response.json())
        .then(data => {

            var linkedPagesContainer = document.querySelector('#linked-urls');
            linkedPagesContainer.innerHTML = ''; // Clear existing content

            data.urls.forEach(url => {
                var link = document.createElement('a');
                link.classList.add('text-blue-500', 'hover:text-blue-700', 'truncate');
                link.href = url;
                link.target = '_blank';
                link.textContent = url;
                linkedPagesContainer.appendChild(link);
            });
        });
}

