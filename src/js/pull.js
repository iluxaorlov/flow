'use strict';

import main from './main';

export default (function() {

    if (main.chat) {
        // number of messages in database
        let count = 0;
        let isBottomOfPage = true;

        window.addEventListener('scroll', function() {
            isBottomOfPage = window.scrollY >= document.documentElement.scrollHeight - window.innerHeight - 16;
        });

        function pull() {
            let xhr = new XMLHttpRequest();
            let data = new FormData();
            data.append('count', count);

            xhr.onreadystatechange = function() {
                if (this.readyState !== 4) return;

                if (this.status === 200) {
                    if (this.responseText) {
                        let json = JSON.parse(this.responseText);
                        create(json.response);
                        // saving new number of messages in database
                        count = json.server;
                    }

                    return pull();
                }
                
                setTimeout(pull, 5000);
            }
        
            xhr.open('POST', '/pull', true);
            xhr.send(data);
        }

        function create(response) {
            while (document.querySelector('.px')) {
                document.querySelector('.px').remove();
            }

                // insert response in the end of messages list
            main.chat.insertAdjacentHTML('afterbegin', response);

            if (isBottomOfPage) {
                main.scrollToBottom();
            } else {
                main.scrollButton.style.visibility = 'visible';
                main.scrollButtonNotification.style.opacity = 1;
                main.scrollButton.style.opacity = 1;
                main.scrollButton.disabled = false;
            }
        }

        pull();
    }

})();