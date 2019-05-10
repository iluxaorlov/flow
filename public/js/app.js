'use strict';

let app = function() {

    let lastSendMessage;
    let chat = document.getElementById('chat');
    let scrollButton = document.getElementById('scroll');
    let notification = document.getElementById('notification');
    let panel = document.getElementById('panel');
    let textField = document.getElementById('panel__input__field');

    return {
        lastSendMessage: lastSendMessage,
        chat: chat,
        scrollButton: scrollButton,
        notification: notification,
        panel: panel,
        textField: textField,

        scroll: function() {
            let scroll = setInterval(function() {
                window.scrollBy(0, document.documentElement.scrollHeight - window.innerHeight - window.scrollY);
            });

            window.addEventListener('scroll', function() {
                clearInterval(scroll);
            });
        },

        autosize: function() {
            textField.style.height = 19 + 'px';
            textField.style.height = textField.scrollHeight - 32 + 'px';
            panel.style.height = textField.scrollHeight + 'px';
        }
    };

}();