'use strict';

let form = function() {

    let showPassword = document.getElementById('form__password__button');

    if (showPassword) {
        showPassword.addEventListener('click', function() {
            let passwordField = document.getElementById('form__password__input');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.innerHTML = '<i class="fas fa-eye"></i>';
            } else {
                passwordField.type = 'password';
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            }
        });
    }

}();