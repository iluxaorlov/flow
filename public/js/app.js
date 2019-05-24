'use strict';

import load from './load.js';
import pull from './pull.js';
import scroll from './scroll.js';
import send from './send.js';

export default (function() {

    return {
        chat: document.getElementById('chat'),
        scrollButton: document.getElementById('scroll'),
        scrollButtonNotification: document.getElementById('notification'),
        panel: document.getElementById('panel'),
        panelTextField: document.getElementById('panel__input__field'),

        scrollToBottom: function() {
            let scrollToBottom = setInterval(function() {
                window.scrollTo(0, document.documentElement.scrollHeight - window.innerHeight);

                setTimeout(function() {
                    clearInterval(scrollToBottom);
                }, 250);
            });
        },

        textFieldAutosize: function() {
            this.panelTextField.style.height = 19 + 'px';
            this.panelTextField.style.height = this.panelTextField.scrollHeight - 32 + 'px';
            this.panel.style.height = this.panelTextField.scrollHeight + 'px';
        },

        textFieldReset: function() {
            this.panelTextField.blur();
            this.panelTextField.value = '';
            this.panelTextField.focus();
            this.textFieldAutosize();
            this.scrollToBottom();
        }
    };

})();

load();
pull();
scroll();
send();