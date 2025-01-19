const decimalFields = document.querySelectorAll('.decimal-field');

decimalFields.forEach(field => {
    field.addEventListener('blur', () => {
        let value = field.value;  // Use 'field' instead of 'this'

        if (value && !value.includes('.')) {
            // Add .00 if no decimal point is present
            field.value = parseFloat(value).toFixed(2);
        }
    });
});

