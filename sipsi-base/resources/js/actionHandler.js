function handleAction(tableId, actionClass, inputId, modal, type = null, containerId = null) {
    $(tableId).on('click', actionClass, function() {
        var id = $(this).data("id");
        $(inputId).val(id);

        if (type && containerId) {
            var actionType = $(this).data("tipe");
            if (actionType === type) {
                $(containerId).removeClass('hidden');
            } else {
                $(containerId).addClass('hidden');
            }
        }

        modal.show();
    });
}

// Export function
window.handleAction = handleAction;
