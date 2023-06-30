//window._ = _;

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';

// import { showNotification } from "./notification.js";
//window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    forceTLS: false,
    encrypted: false,
    enabledTransports: ['ws', 'wss'],
});
// showNotification("Hello", { body: "Welcome to my website!" });
// console.log(window.Echo.connector.pusher.connection);
//
// window.Echo.connector.pusher.connection.bind('disconnected', () => {
//     console.log('disconnected');
// });
