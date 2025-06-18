//window._ = _;

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: 'websocket.e-kezek.shakarim.kz',
    wsPort: 443,
    wssPort: 443,
  //  forceTLS: true,
    encrypted: true,
    enabledTransports: ['ws', 'wss'],
    disabledTransports: ['sockjs', 'xhr_polling', 'xhr_streaming']
});
