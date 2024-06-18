document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('isExternal');
    const pageSelector = document.getElementById('pageSelector');
    const externalUrlField = document.getElementById('externalUrlField');

    function toggleFields() {
        if (checkbox.checked) {
            pageSelector.style.display = 'none';
            externalUrlField.style.display = 'block';
        } else {
            pageSelector.style.display = 'block';
            externalUrlField.style.display = 'none';
        }
    }

    checkbox.addEventListener('change', toggleFields);

    // Trigger the change event if old('isExternal') is set
    if (checkbox.checked) {
        toggleFields();
    }
});