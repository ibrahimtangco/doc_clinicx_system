// addContact.js
import { toggleModalVisibility } from '../utils.js';

document.addEventListener('DOMContentLoaded', () => {
    // Adjusting selector to ensure uniqueness
    const addContactBtn = document.querySelector('.add-contact-btn');
    const addContactModal = document.querySelector('#add-contact');
    const addContactCloseBtn = document.querySelector('#add-contact-close-btn');

    // Confirm these selectors match the intended elements
    if (addContactBtn) {
        addContactBtn.addEventListener('click', () => toggleModalVisibility(addContactModal));
    }

    if (addContactCloseBtn) {
        addContactCloseBtn.addEventListener('click', () => toggleModalVisibility(addContactModal));
    }
});
