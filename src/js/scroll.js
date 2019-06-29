'use strict';

import main from './main';

export default (function() {

    window.addEventListener('scroll', function() {
        if (window.scrollY <= document.documentElement.scrollHeight - window.innerHeight - window.innerHeight) {
            main.scrollButton.style.visibility = 'visible';
            main.scrollButton.style.opacity = 1;
            main.scrollButton.disabled = false;
        }

        if (window.scrollY >= document.documentElement.scrollHeight - window.innerHeight) {
            main.scrollButtonNotification.style.opacity = 0;
            main.scrollButton.style.opacity = 0;
            main.scrollButton.disabled = true;
            
            setTimeout(function() {
                main.scrollButton.style.visibility = 'hidden';
            }, 250);
        }
    });

    main.scrollButton.addEventListener('click', function() {
        let scrollInterval = setInterval(function() {
            window.scrollBy(0, Math.ceil((document.documentElement.scrollHeight - window.innerHeight - window.scrollY) / 10));

            if (window.scrollY === document.documentElement.scrollHeight - window.innerHeight) {
                clearInterval(scrollInterval);
            }
        }, 1000 / 240);
    });

})();