@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="my-4">Clientes</h1>
    
    <div class="mb-3 d-flex align-items-center">
        <input type="text" id="search" placeholder="Buscar cliente por nombre, email, teléfono..." class="form-control me-2" onkeyup="filterClients()">
        <button id="voiceSearch" class="btn btn-secondary">
            <i class="fas fa-microphone"></i>
        </button>
    </div>

    <div id="searchResults" class="alert" style="display: none;"></div>

    <a href="{{ route('clientes.create') }}" class="btn btn-primary mb-3">Agregar Cliente</a>
    
    <table class="table" id="clientesTable">
        <thead>
            <tr>
                <th>Número</th>
                <th>Nombres</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo Electrónico</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $index => $cliente)
                <tr data-id="{{ $cliente->id }}" class="client-row">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $cliente->nombres }}</td>
                    <td>{{ $cliente->apellido_paterno }}</td>
                    <td>{{ $cliente->apellido_materno }}</td>
                    <td>{{ $cliente->correo_electronico }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->direccion }}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning btn-sm me-2 edit-client" data-id="{{ $cliente->id }}">Editar</a>
                            <button class="btn btn-danger btn-sm delete-client" data-id="{{ $cliente->id }}" data-nombres="{{ $cliente->nombres }}" data-apellido-paterno="{{ $cliente->apellido_paterno }}" data-apellido-materno="{{ $cliente->apellido_materno }}">Eliminar</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal para detalles del cliente -->
    <div id="clientModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles del Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="clientDetails"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para confirmación de eliminación -->
    <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar al cliente <span id="clientName"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Sí, eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        #voiceSearch.active {
            background-color: #28a745; /* Color verde oscuro */
        }

        #voiceSearch.active i {
            transform: scale(1.2); /* Aumenta el tamaño */
            transition: transform 0.2s ease; /* Suaviza la transición */
        }

        .client-row:hover {
            background-color: #d0e7ff; /* Color de sombreado más oscuro */
        }

        .modal {
            display: none; /* Inicialmente oculto */
        }
    </style>

    <script>
        function filterClients() {
            const input = document.getElementById('search');
            const filter = input.value.toLowerCase().trim();
            const table = document.getElementById('clientesTable');
            const tr = table.getElementsByTagName('tr');
            let hasResults = false;

            if (filter.length === 0) {
                document.getElementById('searchResults').style.display = 'none';
                for (let i = 1; i < tr.length; i++) {
                    tr[i].style.display = ''; // Muestra todas las filas
                }
                return; 
            }

            const searchTerms = filter.split(' '); // Divide la búsqueda en términos

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td');
                let found = true; // Asumimos que encontramos hasta que se demuestre lo contrario

                for (const term of searchTerms) {
                    const matches = [
                        td[1].textContent.toLowerCase(), // Nombres
                        td[2].textContent.toLowerCase(), // Apellido Paterno
                        td[3].textContent.toLowerCase(), // Apellido Materno
                        td[4].textContent.toLowerCase(), // Correo Electrónico
                        td[5].textContent.toLowerCase(), // Teléfono
                        td[6].textContent.toLowerCase()  // Dirección
                    ];

                    if (!matches.some(match => match.includes(term))) {
                        found = false; // Si algún término no está presente, no lo encontramos
                        break;
                    }
                }

                tr[i].style.display = found ? '' : 'none'; // Muestra u oculta la fila
                if (found) hasResults = true;
            }

            const resultsDiv = document.getElementById('searchResults');
            if (hasResults) {
                resultsDiv.style.display = 'block';
                resultsDiv.className = 'alert alert-success';
                resultsDiv.textContent = 'Búsquedas relacionadas encontradas.';
            } else {
                resultsDiv.style.display = 'block';
                resultsDiv.className = 'alert alert-danger';
                resultsDiv.textContent = 'No se encontró ningún cliente con esa información.';
            }
        }

        document.querySelectorAll('.client-row').forEach(row => {
            row.addEventListener('click', () => {
                const clientId = row.getAttribute('data-id');
                const details = 
                    <strong>ID:</strong> ${clientId}<br>
                    <strong>Nombres:</strong> ${row.children[1].textContent}<br>
                    <strong>Apellido Paterno:</strong> ${row.children[2].textContent}<br>
                    <strong>Apellido Materno:</strong> ${row.children[3].textContent}<br>
                    <strong>Correo Electrónico:</strong> ${row.children[4].textContent}<br>
                    <strong>Teléfono:</strong> ${row.children[5].textContent}<br>
                    <strong>Dirección:</strong> ${row.children[6].textContent}
                ;
                document.getElementById('clientDetails').innerHTML = details;
                $('#clientModal').modal('show');
            });
        });

        document.querySelectorAll('.delete-client').forEach(button => {
            button.addEventListener('click', (event) => {
                event.stopPropagation(); // Evita que el evento se propague y abra el modal de detalles
                const clientId = button.getAttribute('data-id');
                const nombres = button.getAttribute('data-nombres');
                const apellidoPaterno = button.getAttribute('data-apellido-paterno');
                const apellidoMaterno = button.getAttribute('data-apellido-materno');

                document.getElementById('clientName').textContent = ${nombres} ${apellidoPaterno} ${apellidoMaterno};
                
                $('#deleteModal').modal('show');
                
                document.getElementById('confirmDelete').onclick = () => {
                    // Aquí se debe enviar el formulario para eliminar
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = /clientes/${clientId}; // Asegúrate de que esta ruta sea correcta

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}'; // Token CSRF

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE'; // Método para la eliminación

                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);
                    document.body.appendChild(form);
                    form.submit(); // Envía el formulario
                };
            });
        });

        document.querySelectorAll('.edit-client').forEach(button => {
            button.addEventListener('click', (event) => {
                event.stopPropagation(); // Evita que el evento se propague y abra el modal de detalles
            });
        });

        // Búsqueda por voz
        document.getElementById('voiceSearch').addEventListener('click', () => {
            const button = document.getElementById('voiceSearch');
            button.classList.add('active'); // Cambia el color
            const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.lang = 'es-ES';
            recognition.start();

            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript.toLowerCase().trim();
                document.getElementById('search').value = transcript; // Establece el valor del input de búsqueda
                filterClients(); // Llama a la función de filtrado
            };

            recognition.onend = () => {
                button.classList.remove('active'); // Restaura el color
            };

            recognition.onerror = (event) => {
                console.error('Error de reconocimiento: ', event.error);
                button.classList.remove('active'); // Restaura el color
            };
        });
    </script>
@endsection