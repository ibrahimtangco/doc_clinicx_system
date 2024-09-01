// updateFooter.js
import { toggleModalVisibility } from '../utils.js';

document.addEventListener('DOMContentLoaded', () => {
    const updateFooterModal = document.querySelector('#update-footer');
    const updateFooterCloseBtn = document.querySelector('#update-footer-close-btn');

    updateFooterCloseBtn.addEventListener('click', () => toggleModalVisibility(updateFooterModal));

    window.updateFooter = (footer) => {
        toggleModalVisibility(updateFooterModal);
        document.querySelector('#update-footer-description-input').value = footer.description;
    };
});
