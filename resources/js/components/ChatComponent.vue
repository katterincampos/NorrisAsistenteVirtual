<template>
    <div id="appAlumno">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">CHAT USUARIOS</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <ul id="ltsMensajes">
                                    <li v-for="msg in messages" :key="msg._id">
                                        {{ msg.from }}: {{ msg.message }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10">
                                <form id="frmChat" v-on:submit.prevent="sendMessage">
                                    <input type="text" v-model="newMessage.message"
                                        required placeholder="Escribe aqui tu mensaje." class="form-control"/>
                                    <input type="submit" value="Enviar"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import io from 'socket.io-client';

export default {
  data() {
    return {
      userId: 'dt31', // Reemplaza esto con el ID del usuario actual
      chatId: 'chat_dt3_paciente3', // Reemplaza esto con el ID del chat actual
      newMessage: {
        from: 'dt31', // Reemplaza esto con el ID del usuario actual
        to: 'paciente1', // Reemplaza esto con el ID del destinatario
        message: '',
        status: '', // en espera, enviado, recibido, leido
        fecha: new Date()
      },
      messages: [],
      socket: null,
    };
  },
  created() {
    this.socket = io('http://localhost:3000');

    // Emitir un evento 'userConnected' cuando te conectes
    this.socket.emit('userConnected', { userId: this.userId, chatId: this.chatId });

    this.socket.on('messages', (messages) => {
      this.messages = messages;
    });

    this.socket.on('newMessage', (message) => {
      this.messages.push(message);
    });

    this.obtenerHistorial();

    this.socket.on('chat', chat => {
      this.messages.push(chat);
    });
  },
  methods: {
    sendMessage() {
      if (this.newMessage.message != '') {
        this.messages.push({ ...this.newMessage });
        this.socket.emit('chat', this.newMessage);
        this.newMessage.message = '';
      } else {
        alert('Por favor escriba un mensaje');
      }
    },
    obtenerHistorial() {
      this.socket.emit('historial', { userId: this.userId, chatId: this.chatId });
      this.socket.on('historial', chats => {
        console.log('Recibiendo historial para chatId:', this.chatId); // Añade esta línea
        console.log('Mensajes recibidos:', chats); // Añade esta línea
        this.messages = chats;
      });
    }
  }
}
</script>
