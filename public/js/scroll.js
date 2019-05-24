'use strict';

import app from './app.js';

export default function scroll() {

    window.addEventListener('scroll', function() {
        if (window.scrollY <= document.documentElement.scrollHeight - window.innerHeight - window.innerHeight) {
            app.scrollButton.style.visibility = 'visible';
            app.scrollButton.style.opacity = 1;
            app.scrollButton.disabled = false;
        }

        if (window.scrollY >= document.documentElement.scrollHeight - window.innerHeight) {
            app.scrollButtonNotification.style.opacity = 0;
            app.scrollButton.style.opacity = 0;
            app.scrollButton.disabled = true;
            
            setTimeout(function() {
                app.scrollButton.style.visibility = 'hidden';
            }, 250);
        }
    });

    app.scrollButton.addEventListener('click', function() {
        let scrollInterval = setInterval(function() {
            window.scrollBy(0, Math.ceil((document.documentElement.scrollHeight - window.innerHeight - window.scrollY) / 10));

            if (window.scrollY === document.documentElement.scrollHeight - window.innerHeight) {
                clearInterval(scrollInterval);
            }
        }, 1000 / 240);
    });

}