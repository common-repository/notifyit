(function () {
    'use strict';
    var delay = notify_options.notify_delay || 1000,
        msg = notify_options.notify_msg || 'Hi there!',
        eff = notify_options.notify_effect,
        notification;

    function initNotify() {
        setTimeout(function() {
            notification = new NotificationFx({
                message: '<p>'+ msg +'</p>',
                layout: 'growl',
                effect: eff,
                type: 'notice'
            });

            notification.show();
        }, delay);
    }

    window.onload = initNotify();
})();
