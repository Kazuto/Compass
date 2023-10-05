import './bootstrap';

document.querySelectorAll(`[data-toggle="modal"]`)
    .forEach((button) => {
        const modal = document.querySelector(`#${button.getAttribute('data-target')}`)

        button.addEventListener("click", () => {
            modal.showModal();
        });

        modal.querySelector('[data-action="close"]')
            .addEventListener("click", () => {
                modal.close();
            })
    })
