// updateEmailAddress.js
import { toggleModalVisibility } from '../utils.js';

document.addEventListener('DOMContentLoaded', () => {
    const updateEmailAddressModal = document.querySelector('#update-email-address');
    const updateEmailAddressCloseBtn = document.querySelector('#update-email-address-close-btn');

    updateEmailAddressCloseBtn.addEventListener('click', () => toggleModalVisibility(updateEmailAddressModal));

    window.updateEmailAddress = (contact) => {
        toggleModalVisibility(updateEmailAddressModal);
        document.querySelector('#update-email-address-input').value = contact.email;

        document.querySelectorAll('.contact-id').forEach(element => {
            element.value = contact.id;
        });
    };
});
