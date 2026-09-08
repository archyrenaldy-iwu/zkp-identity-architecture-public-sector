function initializeModal(elementId) {
    var modalElement = document.getElementById(elementId);
    var modal = new Modal(modalElement);

    var closeModalButtons = modalElement.querySelectorAll('[data-modal-hide]');
    closeModalButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            modal.hide();
        });
    });

    return modal;
}

// Export function
window.initializeModal = initializeModal;
