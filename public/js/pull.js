'use strict';

import app from './app.js';

export default function() {

    let countPull = 0;
    let isBottom = true;

    window.addEventListener('scroll', function() {
        isBottom = window.scrollY >= document.documentElement.scrollHeight - window.innerHeight - 16;
    });

    function pull() {
        let xhr = new XMLHttpRequest();
        let data = new FormData();
        data.append('countPull', countPull);

        xhr.onreadystatechange = function() {
            if (this.readyState !== 4) return;
    
            if (this.status === 200) {
                if (this.responseText) {
                    let json = JSON.parse(this.responseText);
                    create(json.response);
                    countPull = json.server;
                }

                return pull();
            }
            
            setTimeout(pull, 5000);
        }
    
        xhr.open('POST', '/pull', true);
        xhr.send(data);
    }

    function create(response) {
        while (document.getElementsByClassName('px')[0]) {
            document.getElementsByClassName('px')[0].remove();
        }

        app.chat.insertAdjacentHTML('afterbegin', response);

        if (isBottom) {
            app.scrollToBottom();
        } else {
            app.scrollButton.style.visibility = 'visible';
            app.scrollButtonNotification.style.opacity = 1;
            app.scrollButton.style.opacity = 1;
            app.scrollButton.disabled = false;
        }
    }

    pull();

}