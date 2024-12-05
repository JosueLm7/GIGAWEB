@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Aquí va tu código HTML para el chat -->
    </div>
</div>

<script>
    // Aquí va el código JavaScript que proporcionaste
    let ultimoMensajeId = null;

    function cargarMensajes(usuarioId) {
        fetch(`/chat/${usuarioId}`)
            .then(response => response.json())
            .then(data => {
                const chatContainer = document.getElementById('chat-mensajes');
                chatContainer.innerHTML = ''; // Limpiar mensajes anteriores
                let lastDate = null;

                data.mensajes.forEach(mensaje => {
                    const messageDate = new Date(mensaje.created_at);
                    const formattedDate = messageDate.toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                    const messageTime = messageDate.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });

                    if (lastDate !== formattedDate) {
                        const dateSeparator = document.createElement('div');
                        dateSeparator.className = 'date-separator';
                        dateSeparator.textContent = formattedDate;
                        chatContainer.appendChild(dateSeparator);
                        lastDate = formattedDate;
                    }

                    const isOwnMessage = mensaje.remitente_id === {{ auth()->id() }};
                    const messageDiv = document.createElement('div');
                    messageDiv.className = isOwnMessage ? 'message sent' : 'message received';
                    messageDiv.innerHTML = `<strong>${isOwnMessage ? 'Tú' : mensaje.remitente.nombre}:</strong> ${mensaje.mensaje} <span class="message-time" style="font-size: 0.8em; color: gray;">${messageTime}</span>`;
                    chatContainer.appendChild(messageDiv);

                    // Actualiza el ID del último mensaje
                    ultimoMensajeId = mensaje.id;
                });
                chatContainer.scrollTop = chatContainer.scrollHeight; // Desplazarse hacia abajo
            });
    }

    function obtenerNuevosMensajes(usuarioId) {
        fetch('/chat/nuevos', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                usuario_id: usuarioId,
                ultimo_id: ultimoMensajeId
            }),
        })
        .then(response => response.json())
        .then(data => {
            const chatContainer = document.getElementById('chat-mensajes');

            data.forEach(mensaje => {
                const messageDate = new Date(mensaje.created_at);
                const formattedDate = messageDate.toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                const messageTime = messageDate.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });

                const isOwnMessage = mensaje.remitente_id === {{ auth()->id() }};
                const messageDiv = document.createElement('div');
                messageDiv.className = isOwnMessage ? 'message sent' : 'message received';
                messageDiv.innerHTML = `<strong>${isOwnMessage ? 'Tú' : mensaje.remitente.nombre}:</strong> ${mensaje.mensaje} <span class="message-time" style="font-size: 0.8em; color: gray;">${messageTime}</span>`;
                chatContainer.appendChild(messageDiv);
                
                // Actualiza el ID del último mensaje
                ultimoMensajeId = Math.max(ultimoMensajeId, mensaje.id);
            });
            chatContainer.scrollTop = chatContainer.scrollHeight;
        });
    }

    document.querySelectorAll('.usuario-item').forEach(item => {
        item.addEventListener('click', function() {
            const usuarioId = this.getAttribute('data-usuario-id');
            cargarMensajes(usuarioId);
            setInterval(() => obtenerNuevosMensajes(usuarioId), 3000);
        });
    });
</script>
@endsection
