const templates = document.querySelectorAll('.templates-container > div');
templates.forEach(template => {
  template.addEventListener('dragstart', handleDragStart);
});

const activeTemplates = document.querySelector('.active-templates');

activeTemplates.addEventListener('dragover', handleDragOver);
activeTemplates.addEventListener('drop', handleDrop);

function handleDragStart(e) {
  e.dataTransfer.setData('text/plain', e.target.id);
}

function handleDragOver(e) {
  e.preventDefault();
}

function handleDrop(e) {
  e.preventDefault();

  const templateId = e.dataTransfer.getData('text/plain');
  const template = document.getElementById(templateId);

  addTemplateToPage(template.dataset.templateId);
}

function addTemplateToPage(templateId) {
  fetch('/admin/page/add-template', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
      'templateId': templateId,
      'pageId': document.querySelector('meta[name="page-id"]').getAttribute('content')
    })
  })
    .then(response => response.json())
    .then(data => {
      // Set open accordions in sessionStorage
      const openAccordions = document.querySelectorAll('.templates-container .accordion-button.open');
      const openAccordionTargets = Array.from(openAccordions).map(accordion => accordion.dataset.accordionTarget);

      sessionStorage.setItem('openAccordionTargets', JSON.stringify(openAccordionTargets));

      window.location.reload();
    });
}

// Load open accordions from sessionStorage
const openAccordionTargets = JSON.parse(sessionStorage.getItem('openAccordionTargets'));

if (openAccordionTargets) {
  openAccordionTargets.forEach(target => {
    document.querySelector(`.templates-container .accordion-button[data-accordion-target="${target}"]`).classList.add('open');
  });
}

sessionStorage.removeItem('openAccordionTargets');