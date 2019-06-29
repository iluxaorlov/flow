'use strict';

export default (function() {

    if (document.getElementById('password__section__show')) {
        document.getElementById('password__section__show').addEventListener('click', function() {
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

})();