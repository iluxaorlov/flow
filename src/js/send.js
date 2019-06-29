'use strict';

import main from './main';

export default (function() {

    main.panelTextField.addEventListener('input', function() {
        main.textFieldAutosize();
        main.scrollToBottom();
    });

    document.getElementById('panel__input__button').addEventListener('click', preSend);

    main.panelTextField.addEventListener('keydown', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            preSend();
        }
    });

    function preSend() {
        if (main.panelTextField.value.trim() === '') {
            main.panelTextField.focus();
        } else {
            send(main.panelTextField.value.trim());
        }
    }

    function send(text) {
        let message = create(text);
        let xhr = new XMLHttpRequest();
        let data = new FormData();
        data.append('text', text);

        xhr.onerror = function() {
            this.abort();
            message.className = 'ex';
        }

        xhr.ontimeout = function() {
            this.abort();
            message.className = 'ex';
        }

        xhr.open('POST', '/send', true);
        xhr.timeout = 5000;
        xhr.send(data);
    }

    function create(text) {
        text = formatText(text);

        if (!text) {
            return;
        }

        let message = document.createElement('p');
        message.className = 'px';
        message.innerText = text;
        main.chat.insertBefore(message, main.chat.firstChild);
        main.textFieldReset();
        return message;
    }

    function formatText(text) {
        text = text.trim().replace(/\s+\n+/g, ' ');

        if (!text) {
            return null;
        }

        return text;
    }

})();