@extends('layouts.appweb')
@section('content')
    <style>
        .message p, .message ul {
            margin: 0 0 10px 0;
        }
        .assistant-message ul {
            padding-left: 20px;
            margin: 0;
        }
        .assistant-message p {
            margin: 0 0 10px 0;
        }
        .message li {
            margin: 5px 0;
        }

        #chat-box {
            background-color: #fff;
            border: 1px solid #e6e6e6;
            border-radius: 15px;
            box-shadow: 0 0 10px #e6e6e6;
            height: 460px;
            overflow-y: scroll;
            padding: 15px;

        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 10px;
            width: fit-content;
        }
        .user-message {
            background-color: #e6e6e6;
            align-self: flex-start;
            order: 1;
        }
        .assistant-message {
            background-color: #d1ecf1;
            align-self: flex-end;
            order: 2;
            margin-left: auto;
        }
        .loading-spinner {
            text-align: right;
            display: none;
        }
        .input-group {
            border-radius: 15px;
            overflow: hidden;
        }
        .input-group input, .input-group button {
            border-radius: 0;
        }
        .input-group button {
            background-color: #007bff;
            color: #fff;
        }
        .quick-actions button {
            margin: 0 5px 5px 0;
        }
    </style>

<div class="container mt-5">
    <div id="chat-box"></div>
    <div id="loading-spinner" class="loading-spinner mb-3">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Cargando...</span>
        </div>
    </div>
    <div id="user-input" class="mb-3">
        <div class="input-group">
            <input type="text" id="message" class="form-control" placeholder="Escribe tu mensaje aquí..." />
            <div class="input-group-append">
                <button class="btn" onclick="sendMessage()">Enviar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function sendMessage() {
        const chatBox = document.getElementById('chat-box');
        const messageInput = document.getElementById('message');

        const userMessage = messageInput.value.trim();
        if (userMessage === '') return;

        // Añadir el mensaje del usuario al chat
        chatBox.innerHTML += `<div class="message user-message">Usuario: ${userMessage}</div>`;
        messageInput.value = '';

        // Añadir un mensaje de "Cargando..." al chat
        const loadingMessageDiv = document.createElement('div');
        loadingMessageDiv.className = 'message assistant-message';
        loadingMessageDiv.innerHTML = '<div class="p-3 text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Cargando...</span></div></div>';
        chatBox.appendChild(loadingMessageDiv);

        // Hacer la solicitud AJAX al servidor
        fetch('/openai/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ user_message: userMessage }),
        })
        .then(response => {
            if (!response.ok) throw new Error('Hubo un error al comunicarse con el servidor');
            return response.json();
        })
        .then(data => {
            // Estructurar el mensaje del asistente con HTML
            let assistantMessage = '';
            const listRegex = /\d+\.\s.+/g;
            const messageParts = data.message.split('\n');
            let isList = false;
            
            messageParts.forEach(part => {
                if (listRegex.test(part)) {
                    if (!isList) {
                        isList = true;
                        assistantMessage += '<ul>';
                    }
                    assistantMessage += `<li>${part.replace(listRegex, match => match.slice(2))}</li>`;
                } else {
                    if (isList) {
                        isList = false;
                        assistantMessage += '</ul>';
                    }
                    assistantMessage += `<p>${part}</p>`;
                }
            });
            if (isList) assistantMessage += '</ul>';
            
            // Actualizar el mensaje de "Cargando..." con la respuesta del asistente
            loadingMessageDiv.innerHTML = `Asistente: ${assistantMessage}`;
        })
        .catch(error => {
            console.error(error);
            loadingMessageDiv.innerHTML = 'Asistente: Hubo un error al procesar tu solicitud. Por favor, inténtalo de nuevo más tarde.';
        })
        .finally(() => {
            // Hacer scroll al último mensaje en el chat
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    }

    function sendQuickAction(message) {
        document.getElementById('message').value = message;
        sendMessage();
    }
</script>
@endsection