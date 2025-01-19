const inputField = document.querySelector('.prevent-paste');

inputField.addEventListener('paste', e => e.preventDefault());
