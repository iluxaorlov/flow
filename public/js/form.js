'use strict';

export default function form() {

    let showPassword = document.getElementById('password__section__show');

    if (showPassword) {
        showPassword.addEventListener('click', function() {
            let passwordField = document.getElementById('password__section__input');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.innerHTML = '<i class="fas fa-eye"></i>';
            } else {
                passwordField.type = 'password';
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            }
        });
    }

}