import './bootstrap';
import initTheme from './theme';

initTheme();

document.querySelectorAll(`[data-toggle="modal"]`).forEach((button) => {
    const modal = document.querySelector(
        `#${button.getAttribute('data-target')}`
    );

    button.addEventListener('click', () => {
        modal.showModal();
    });

    modal
        .querySelector('[data-action="close"]')
        .addEventListener('click', () => {
            modal.close();
        });
});

document
    .querySelectorAll(`input[type="checkbox"][data-target]`)
    .forEach((checkbox) => {
        const hidden = document.querySelector(
            `#${checkbox.getAttribute('data-target')}`
        );

        checkbox.addEventListener('change', () => {
            hidden.value = checkbox.checked ? 1 : 0;
        });
    });
