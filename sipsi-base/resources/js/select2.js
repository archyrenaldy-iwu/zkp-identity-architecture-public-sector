function initializeSelect2(elements) {
    elements.forEach(function(element) {
        $(element).select2();
    });
}

// Export function
window.initializeSelect2 = initializeSelect2;
