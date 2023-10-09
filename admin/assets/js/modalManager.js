class ModalHandler {
    constructor () {
        this.closeModalButtons = $('button[data-button-type="close-modal"]');
        this.openModalButtons = $('button[data-button-type="open-modal"]');
        this.modals = $('section[data-container="modal"]');
        this.initialize();
    }
    initialize() {
        this.closeModalButtons.each((_, button) => {
            $(button).on("click", this.closeModal.bind(this));
        });

        this.openModalButtons.each((_, button) => {
            $(button).on("click", this.openModal.bind(this));
        });
    }

    closeModal(event) {
        $(event.target).closest("section").hide();
    }

    openModal(event) {
        const button = $(event.target);
        const buttonModalName = button.attr('data-modal-name');

        const matchingModals = this.modals.filter(`[data-modal-name="${buttonModalName}"]`);

        if (matchingModals.length > 0) {
            matchingModals.css({
                'display': 'grid',
                'place-items': 'center',
                'justify-content': 'center',
                'align-items': 'center'
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new ModalHandler();
});
