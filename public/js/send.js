'use strict';

import app from './app.js';

export default function() {
    
    document.getElementById('panel__input__button').addEventListener('click', function() {
        if (app.panelTextField.value === '') {
            app.panelTextField.focus();
            return;
        }

        send(app.panelTextField.value);
    });

    app.panelTextField.addEventListener('input', function() {
        app.textFieldAutosize();
        app.scrollToBottom();
    });

    app.panelTextField.addEventListener('keydown', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            send(this.value);
        }
    });

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

        xhr.open('POST', '/send');
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
        app.chat.insertBefore(message, app.chat.firstChild);
        app.textFieldReset();
        return message;
    }

    function formatText(text) {
        text = text.trim();
        text = text.replace(/[\n\s]+/g, ' ');
        text = text.slice(0, 512);

        if (!text) {
            return null;
        }

        return text;
    }

}