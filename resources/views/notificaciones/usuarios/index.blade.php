@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4">
            <h3>Buscar Usuarios</h3>
            <input type="text" id="usuario-buscar" class="form-control mb-2" placeholder="Buscar por nombre o email">
            <ul class="list-group" id="usuarios-list">
                @foreach($usuarios as $usuario)
                    <li class="list-group-item usuario-item" data-usuario-id="{{ $usuario->id }}" data-usuario-email="{{ $usuario->email }}">
                        <strong>{{ $usuario->nombre }}</strong>
                        @if($usuario->estado) 
                            <span class="text-success" style="font-size: 1.2em;">●</span> 
                        @else 
                            <span class="text-muted" style="font-size: 1.2em;">●</span>
                        @endif
                        <span class="last-message">{{ $usuario->ultimoMensajeConUsuario(auth()->id()) ?? 'Sin mensajes' }}</span>
                        <span class="last-message-time" style="font-size: 0.8em; color: gray;">{{ $usuario->ultimoMensajeHoraConUsuario(auth()->id()) ?? '' }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-8">
            <h3 id="nombre-usuario-chat">Chat</h3>
            <div id="chat-mensajes" style="border: 1px solid #ccc; padding: 10px; height: 300px; overflow-y: scroll;">
                <!-- Aquí se mostrarán los mensajes -->
            </div>
            <form id="chat-form" style="display: none;" class="mt-2">
                @csrf
                <input type="hidden" id="receptor_id" name="receptor_id" value="">
                <div class="input-group">
                    <button type="button" id="emoji-button" class="btn btn-light">
                        <i class="fas fa-smile"></i>
                    </button>
                    <input type="text" name="mensaje" id="mensaje" class="form-control" placeholder="Escribe un mensaje..." required>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
                <div id="emoji-picker" style="display: none; position: absolute; background: white; border: 1px solid #ccc; border-radius: 5px; padding: 10px; z-index: 1000;">
                    <span class="emoji" data-emoji="😀">😀</span>
                    <span class="emoji" data-emoji="😁">😁</span>
                    <span class="emoji" data-emoji="😂">😂</span>
                    <span class="emoji" data-emoji="😃">😃</span>
                    <span class="emoji" data-emoji="😄">😄</span>
                    <span class="emoji" data-emoji="😅">😅</span>
                    <span class="emoji" data-emoji="😆">😆</span>
                    <span class="emoji" data-emoji="😉">😉</span>
                    <span class="emoji" data-emoji="😊">😊</span>
                    <span class="emoji" data-emoji="😋">😋</span>
                    <span class="emoji" data-emoji="😎">😎</span>
                    <span class="emoji" data-emoji="😍">😍</span>
                    <span class="emoji" data-emoji="😢">😢</span>
                    <span class="emoji" data-emoji="😠">😠</span>
                    <span class="emoji" data-emoji="😇">😇</span>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const usuarioBuscar = document.getElementById('usuario-buscar');
    const usuariosList = document.getElementById('usuarios-list');
    const usuarioItems = Array.from(usuariosList.children);

    usuarioBuscar.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        usuarioItems.forEach(item => {
            const userName = item.textContent.toLowerCase();
            const userEmail = item.dataset.usuarioEmail.toLowerCase();
            if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    document.querySelectorAll('.usuario-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.usuario-item').forEach(i => i.classList.remove('selected'));
            this.classList.add('selected');
            const usuarioId = this.getAttribute('data-usuario-id');
            const usuarioNombre = this.querySelector('strong').innerText;
            document.getElementById('nombre-usuario-chat').innerText = usuarioNombre;
            document.getElementById('receptor_id').value = usuarioId;
            cargarMensajes(usuarioId);
            document.getElementById('chat-form').style.display = 'block'; // Mostrar el formulario al seleccionar un usuario
        });
    });

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
                    
                    // Verifica si se necesita un separador de fecha
                    if (lastDate !== formattedDate) {
                        const dateSeparator = document.createElement('div');
                        dateSeparator.className = 'date-separator';
                        dateSeparator.textContent = formattedDate;
                        chatContainer.appendChild(dateSeparator);
                        lastDate = formattedDate;
                    }

                    const isOwnMessage = mensaje.remitente_id === {{ auth()->id() }}; // Comparar ID
                    const messageDiv = document.createElement('div');
                    messageDiv.className = isOwnMessage ? 'message sent' : 'message received'; // Clases para CSS
                    messageDiv.innerHTML = `<strong>${isOwnMessage ? 'Tú' : mensaje.remitente.nombre}:</strong> ${mensaje.mensaje} <span class="message-time" style="font-size: 0.8em; color: gray;">${messageTime}</span>`;
                    chatContainer.appendChild(messageDiv);
                });
                chatContainer.scrollTop = chatContainer.scrollHeight; // Desplazarse hacia abajo
            });
    }

    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const mensajeInput = document.getElementById('mensaje');
        const receptorId = document.getElementById('receptor_id').value;

        fetch('/chat', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                mensaje: mensajeInput.value,
                receptor_id: receptorId,
            }),
        }).then(response => {
            if (response.ok) {
                const lastMessage = mensajeInput.value; // Mensaje enviado
                const messageTime = new Date().toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
                actualizarUltimoMensaje(receptorId, lastMessage, messageTime); // Actualizar la lista de usuarios
                mensajeInput.value = '';
                cargarMensajes(receptorId); // Recargar mensajes
            }
        });
    });

    function actualizarUltimoMensaje(usuarioId, mensaje, hora) {
        const usuarioItem = document.querySelector(`.usuario-item[data-usuario-id="${usuarioId}"]`);
        if (usuarioItem) {
            const lastMessageElement = usuarioItem.querySelector('.last-message');
            const lastMessageTimeElement = usuarioItem.querySelector('.last-message-time');
            lastMessageElement.textContent = mensaje; // Actualizar el último mensaje
            lastMessageTimeElement.textContent = hora; // Actualizar la hora del último mensaje
        }
    }

    // Emoji Picker
    const emojiButton = document.getElementById('emoji-button');
    const emojiPicker = document.getElementById('emoji-picker');

    emojiButton.addEventListener('click', function() {
        emojiPicker.style.display = emojiPicker.style.display === 'none' ? 'block' : 'none';
    });

    document.querySelectorAll('.emoji').forEach(emoji => {
        emoji.addEventListener('click', function() {
            const emojiValue = this.getAttribute('data-emoji');
            const mensajeInput = document.getElementById('mensaje');
            mensajeInput.value += emojiValue; // Agregar emoji al campo de mensaje
            emojiPicker.style.display = 'none'; // Cerrar el selector de emojis
        });
    });

    // Cerrar el selector de emojis al hacer clic fuera
    document.addEventListener('click', function(event) {
        if (!emojiButton.contains(event.target) && !emojiPicker.contains(event.target)) {
            emojiPicker.style.display = 'none';
        }
    });
</script>

<style>
    #chat-mensajes {
        display: flex;
        flex-direction: column;
    }

    .message {
        margin: 5px;
        padding: 10px;
        border-radius: 5px;
        max-width: 70%;
    }

    .sent {
        align-self: flex-end; /* Alínea a la derecha */
        background-color: #d1e7dd; /* Color para mensajes enviados */
    }

    .received {
        align-self: flex-start; /* Alínea a la izquierda */
        background-color: #f8d7da; /* Color para mensajes recibidos */
    }

    .usuario-item {
        cursor: pointer;
    }

    .usuario-item:hover {
        background-color: #f0f0f0; /* Sombreado al pasar el cursor */
    }

    .usuario-item.selected {
        background-color: #cce5ff; /* Color celeste al seleccionar */
    }

    .date-separator {
        text-align: center;
        font-weight: bold;
        margin: 10px 0;
        color: #666;
    }

    #emoji-picker {
        display: flex;
        flex-wrap: wrap;
        max-width: 250px;
    }

    .emoji {
        cursor: pointer;
        font-size: 24px;
        margin: 5px;
    }
</style>
@endsection
