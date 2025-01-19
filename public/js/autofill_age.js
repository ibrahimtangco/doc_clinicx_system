// birthday age
        const birthday = document.querySelector('#birthday');
        const ageField = document.querySelector('#age');
        const hiddenAge = document.querySelector('#hiddenAge');
        const ageError = document.querySelector('#js-age-error');

        birthday.addEventListener('change', () => {
            const selectedDate = new Date(birthday.value);
            const today = new Date();
            let age = today.getFullYear() - selectedDate.getFullYear();

            if(!isNaN(age)) {
                // Adjust age if birthday for this year hasn't occurred yet
                if (today.getMonth() < selectedDate.getMonth() || (today.getMonth() === selectedDate.getMonth() && today.getDate() < selectedDate.getDate())) {
                    age--;
                }

                // Set the value of the age field as the calculated age
                ageField.value = age.toString();
                hiddenAge.value = age.toString();

                if(age > 0) {
                    ageError.innerHTML = '';
                } else {
                    ageError.innerHTML = 'The age field must be at least 1.';
                }
            }
            else {
                ageError.innerHTML = 'The should be a valid date format dd/mm/yyyy.';
            }
            

            

        });
