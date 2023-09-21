$(document).ready(function () {

    closeModalButton = $('button[data-button-type="close-modal"]');

    closeModalButton.each(function () {
        $(this).on("click", function () {
            console.log("CANCEL OR CLOSE MODAL")
            $(this).closest("section").hide()
        })
    })

    openModalButton = $('button[data-button-type="open-modal"]');
    modalContainer = $('section[data-container="modal"]');

    openModalButton.each(function () {
        $(this).on("click", function () {

            const buttonModalName = $(this).attr('data-modal-name');
            console.log(buttonModalName)

            const matchingModals = $('section[data-container="modal"][data-modal-name="' + buttonModalName + '"]');
            console.log(matchingModals)

            if (matchingModals.length > 0) {
                matchingModals.css({
                    'display': 'grid',
                    'place-items': 'center',
                    'justify-content': 'center',
                    'align-items': 'center'
                });
            }
        });
    });

});