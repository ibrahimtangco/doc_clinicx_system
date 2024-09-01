// addContact.js
import { toggleModalVisibility } from '../utils.js';

document.addEventListener('DOMContentLoaded', () => {
    const addContactBtn = document.querySelector('.add-contact-btn');
    const addContactModal = document.querySelector('#add-contact');
    const addContactCloseBtn = document.querySelector('#add-contact-close-btn');

    addContactBtn.addEventListener('click', () => toggleModalVisibility(addContactModal));
    addContactCloseBtn.addEventListener('click', () => toggleModalVisibility(addContactModal));
});
