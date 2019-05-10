'use strict';

let send = function() {

    document.getElementById('panel__input__button').addEventListener('click', function() {
        if (app.textField.value === '') {
            app.textField.focus();
            return;
        }

        send(app.textField.value);
    });

    app.textField.addEventListener('input', function() {
        app.autosize();
        app.scroll();
    });
    
    app.textField.addEventListener('keydown', function(event) {
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

        xhr.onreadystatechange = function() {
            if (this.readyState !== 4) return;

            if (this.status === 200) {
                app.lastSendMessage = message;
            }
        }

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
        reset();
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

    function reset() {
        app.textField.blur();
        app.textField.value = '';
        app.textField.focus();
        app.autosize();
        app.scroll();
    }

}();