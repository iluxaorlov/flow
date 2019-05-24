'use strict';

import app from './app.js';

export default function() {

    window.addEventListener('scroll', function() {
        if (scrollY === 0) {
            load();
        }
    });

    function load() {
        let xhr = new XMLHttpRequest();
        let offset = document.getElementsByClassName('tx').length + document.getElementsByClassName('rx').length;
        let data = new FormData();
        data.append('offset', offset);

        xhr.onreadystatechange = function() {
            if (this.readyState !== 4) return;

            if (this.status === 200) {
                if (this.responseText) {
                    create(this.responseText);
                }
            }
        }

        xhr.open('POST', '/load', true);
        xhr.send(data);
    }

    function create(response) {
        let lastPosition = document.documentElement.scrollHeight;
        app.chat.insertAdjacentHTML('beforeend', response);
        window.scrollTo(0, document.documentElement.scrollHeight - lastPosition);
    }

}