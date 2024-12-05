import './bootstrap'; // Asegúrate de que bootstrap.js exista y se importe correctamente
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'f4ddf1134854b105a667', // Asegúrate de que esto sea correcto
    cluster: 'us2', // Asegúrate de que esto sea correcto
    forceTLS: true,
});

// Asegúrate de que el evento se escuche después de que el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    const usuarioId = document.getElementById('usuario-id')?.value;

    if (usuarioId) {
        Echo.private(`chat.${usuarioId}`)
            .listen('MensajeEnviado', (e) => {
                console.log('Nuevo mensaje:', e.mensaje);
                const chatContainer = document.getElementById('chat-mensajes');
                chatContainer.innerHTML += `<div><strong>${e.mensaje.remitente_id}:</strong> ${e.mensaje.mensaje}</div>`;
            });
    }
});
