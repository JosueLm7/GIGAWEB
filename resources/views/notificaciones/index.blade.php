@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4">
            <h3>Usuarios</h3>
            <ul class="list-group" id="usuarios-list">
                @foreach($usuarios as $usuario)
                    <li class="list-group-item usuario-item" data-usuario-id="{{ $usuario->id }}">
                        <strong>{{ $usuario->nombre }}</strong>
                        @if($usuario->estado) 
                            <span class="text-success" style="font-size: 1.2em;">●</span> 
                        @else 
                            <span class="text-muted" style="font-size: 1.2em;">●</span>
                        @endif
                        <span class="last-message">{{ $usuario->ultimoMensaje() ?? '' }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-8">
            <h3>Chat</h3>
            <div id="chat-mensajes" style="border: 1px solid #ccc; padding: 10px; height: 300px; overflow-y: scroll;">
                <!-- Aquí se mostrarán los mensajes -->
            </div>
            <form id="chat-form" style="display: none;">
                @csrf
                <input type="hidden" id="receptor_id" name="receptor_id" value="">
                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <input type="text" name="mensaje" id="mensaje" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.usuario-item').forEach(item => {
        item.addEventListener('click', function() {
            const usuarioId = this.getAttribute('data-usuario-id');
            document.getElementById('receptor_id').value = usuarioId;
            document.getElementById('chat-form').style.display = 'block';
            cargarMensajes(usuarioId);
        });
    });

    function cargarMensajes(usuarioId) {
        fetch(`/chat/${usuarioId}`)
            .then(response => response.json())
            .then(data => {
                const chatContainer = document.getElementById('chat-mensajes');
                chatContainer.innerHTML = ''; // Limpiar mensajes anteriores
                data.mensajes.forEach(mensaje => {
                    const isOwnMessage = mensaje.remitente_id === '{{ auth()->id() }}'; // Comparar ID
                    const messageDiv = document.createElement('div');
                    messageDiv.className = isOwnMessage ? 'message sent' : 'message received'; // Clases para CSS
                    messageDiv.innerHTML = `<strong>${isOwnMessage ? 'Tú' : mensaje.remitente.nombre}:</strong> ${mensaje.mensaje}`;
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
                mensajeInput.value = '';
                cargarMensajes(receptorId); // Recargar mensajes
            }
        });
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
</style>
@endsection
