import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY, // Verifica que este valor sea correcto
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER, // Verifica que este valor sea correcto
    forceTLS: true,
});
