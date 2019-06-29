'use strict';

import app from './main';

export default (function() {

    let inProgress = false;

    window.addEventListener('scroll', function() {
        if (scrollY === 0) {
            if (inProgress === false) {
                inProgress = true;
                load();
            }
        }
    });

    function load() {
        let xhr = new XMLHttpRequest();
        // number of messages on the page
        let offset = document.getElementsByClassName('tx').length + document.getElementsByClassName('rx').length;
        let data = new FormData();
        data.append('offset', offset);

        xhr.onreadystatechange = function() {
            if (this.readyState !== 4) return;

            if (this.status === 200) {
                if (this.responseText) {
                    create(this.responseText);
                    inProgress = false;
                }
            }
        }

        xhr.open('POST', '/load', true);
        xhr.send(data);
    }

    function create(response) {
        // saving last position on the page
        let lastPosition = document.documentElement.scrollHeight;
        // insert response in the start of messages list
        app.chat.insertAdjacentHTML('beforeend', response);
        // scrolling to the last position
        window.scrollTo(0, document.documentElement.scrollHeight - lastPosition);
    }

})();