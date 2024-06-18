// NavPlaceHolder height
const siteNavigation = document.querySelector('.site-navigation');
const navPlaceholder = document.querySelector('.nav-placeholder');

if (siteNavigation && navPlaceholder) {
    navPlaceholder.style.height = `${siteNavigation.offsetHeight}px`;

    window.addEventListener('resize', () => {
        navPlaceholder.style.height = `${siteNavigation.offsetHeight}px`;
    });
}

// Hamburger menu toggle
const navbarToggle = document.querySelector('[data-collapse-toggle]');
const navbarMenu = document.getElementById(navbarToggle.getAttribute('aria-controls'));

navbarToggle.addEventListener('click', function () {
    navbarToggle.classList.toggle('active');
    navbarMenu.classList.toggle('hidden');
});

// Dropdown menu keyboard accessibility
document.querySelectorAll('div.dropdown.group').forEach(function (dropdownGroup) {
    const dropdownContent = dropdownGroup.querySelector('.dropdown-content');

    dropdownGroup.querySelectorAll('a').forEach(function (dropdownLink) {
        dropdownLink.addEventListener('focusin', function () {
            console.log('focusin');
            dropdownContent.classList.remove('opacity-0', 'invisible');
        });
    });

    dropdownGroup.addEventListener('focusout', function () {
        dropdownContent.classList.add('opacity-0', 'invisible');
    });
});