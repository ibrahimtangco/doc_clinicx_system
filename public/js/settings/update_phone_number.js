// updatePhoneNumber.js
import { toggleModalVisibility } from '../utils.js';

document.addEventListener('DOMContentLoaded', () => {
    const updatePhoneNumberModal = document.querySelector('#update-phone-number');
    const updatePhoneNumberCloseBtn = document.querySelector('#update-phone-number-close-btn');

    updatePhoneNumberCloseBtn.addEventListener('click', () => toggleModalVisibility(updatePhoneNumberModal));

    window.updatePhoneNumber = (contact) => {
        toggleModalVisibility(updatePhoneNumberModal);
        document.querySelector('#update-phone-number-input').value = contact.phone_number;

        document.querySelectorAll('.contact-id').forEach(element => {
            element.value = contact.id;
        });
    };
});
