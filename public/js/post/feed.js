// Carousel
document.querySelectorAll('.post-media').forEach(element => {
    const items = element.querySelectorAll('[data-carousel-item]');
    const indicators = element.querySelectorAll('[data-carousel-slide-to]');
    const prev = element.querySelector('[data-carousel-prev]');
    const next = element.querySelector('[data-carousel-next]');

    let index = 0;

    const showItem = (index) => {
        items.forEach((item, i) => {
            item.classList.toggle('hidden', i !== index);
        });

        indicators.forEach((indicator, i) => {
            indicator.setAttribute('aria-current', i === index);
        });
    };

    if (element.querySelector('.controls')) {
        const nextItem = () => {
            index = (index + 1) % items.length;
            showItem(index);
        };

        const prevItem = () => {
            index = (index - 1 + items.length) % items.length;
            showItem(index);
        };

        const goToItem = (i) => {
            index = i;
            showItem(index);
        };

        indicators.forEach((indicator, i) => {
            indicator.addEventListener('click', () => goToItem(i));
        });

        prev.addEventListener('click', prevItem);
        next.addEventListener('click', nextItem);
    }

    showItem(index);
});