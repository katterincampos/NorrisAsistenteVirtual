<template>
  <div id="appPaciente" class="container">
    <div class="row">
      <div class="col col-12">
        <div class="chat-container">
          <div class="chat-header bg-primary text-white p-3 d-flex justify-content-between align-items-center">
            <div>
              <img src="../../../public/img/person-circle.svg" alt="">
               {{userName}}
            </div>
            <div>
              <button class="btn btn-light btn-sm">Estadisticas <i class="bi bi-graph-up"></i> </button>
            </div>
          </div>
          <div class="chat-messages p-3">
            <ul id="ltsMensajes" class="list-unstyled">
              <li v-for="msg in messages" :key="msg._id" :class="{'chat-message-emisor': msg.from === userId, 'chat-message-receptor': msg.from !== userId}">
                <div class="chat-bubble p-2 mb-1">
                  <span class="chat-user font-weight-bold">{{ msg.fromName }}</span> {{ msg.message }}
                  <span class="chat-status">{{ msg.status }}</span> <!-- Agregamos el estado del mensaje aquí -->
                </div>
              </li>
            </ul>
          </div>
          <div class="chat-input p-3 bg-light">
            <form id="frmChat" v-on:submit.prevent="sendMessage" class="d-flex">
              <div class="input-group">
                <input type="text" v-model="newMessage.message" required placeholder="Escribe aqui tu mensaje." class="form-control mr-2 col-md-6"/>
                <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="submit" class="btn"><svg  xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="m3 bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                  <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                  </svg></button>
                </div>                  
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  max-width: 100%;
}

.chat-container {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 10px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  height: 80vh; /* Adjust this value as needed */
}

.chat-header {
  flex-shrink: 0;
}

.chat-messages {
  flex-grow: 1;
  overflow-y: auto;
}

.chat-message-emisor .chat-bubble {
  margin-left: auto;
  background-color: #DCF8C6;
  text-align: end; /* Color de fondo para los mensajes del emLo siento, parece que el mensaje se cortó. Aquí está el resto del código:

```html
isor */
}

.chat-message-receptor .chat-bubble {
  margin-right: auto;
  background-color: #FFFFFF; /* Color de fondo para los mensajes del receptor */
}

.chat-bubble {
  background: #f8f8f8;
  border-radius: 10px;
  position: relative;
  width: fit-content;
  height: fit-content;
  margin: 8px;
  padding: auto;
}

.chat-bubble::after {
  content: "";
  position: absolute;
  left: -10px;
  top: 50%;
  width: 0;
  height: 0;
  border: 10px solid transparent;
  border-right-color: #f8f8f8;
  border-left: 0;
  border-right: 10px solid #f8f8f8;
  margin-top: -10px;
  margin-left: -10px;
}

.chat-user {
  font-weight:bold;
  margin-bottom: 5px;
  display: block;
}

.chat-time {
  font-size: 0.8rem;
}

.chat-input {
  flex-shrink: 0;
}
</style>

<script>
import io from 'socket.io-client';
import axios from 'axios';

export default {
  data() {
    return {
      userId: localStorage.getItem('userId'),
      userName: localStorage.getItem('userName'), 
      doctor_Id: localStorage.getItem('doctor_id'),
      doctorName: localStorage.getItem('doctorName'), // Añade esto
      chatId: '',
      newMessage: {
        from: localStorage.getItem('userId'),
        fromName: localStorage.getItem('userName'), // Cambia esto
        to: localStorage.getItem('doctorId'),
        toName: localStorage.getItem('doctorName'), // Cambia esto
        message: '',
        status: '', // en espera, enviado, recibido, leido
        fecha:new Date(),
      },
      messages: [],
      socket: null,
    };
  },
  created() {
    this.getAssignedDoctorId().then(() => {
      this.chatId = 'chat_' + this.doctor_Id + '_' + this.userId;
      this.newMessage.from = this.userId;
      this.newMessage.to = this.doctor_Id;

      this.socket = io('http://localhost:3000');

      // Emitir un evento 'userConnected' cuando te conectes
      this.socket.emit('userConnected', { userId: this.userId, chatId: this.chatId });

      this.socket.on('messages', (messages) => {
        this.messages = messages;
      });

      this.socket.on('newMessage', (message) => {
        this.messages.push(message);
        // Emitir el evento 'messageReceived' al servidor
        this.socket.emit('messageReceived', { messageId: message._id });
      });

      this.obtenerHistorial();

      this.socket.on('chat', chat => {
        this.messages.push(chat);
      });
          setInterval(this.obtenerHistorial, 500);

    });
  },
  methods: {
    sendMessage() {
      if (this.newMessage.message != '') {
        this.newMessage.chatId = this.chatId;
        this.newMessage.fromName = this.userName; // Cambia esto
        this.newMessage.toName = this.doctorName; // Cambia esto
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
        this.messages = chats;
      });
    },
    async getAssignedDoctorId() {
      try {
        const response = await axios.get('api/assignedDoctor/' + this.patientId);
        this.doctorId = response.data.doctorId;
        localStorage.setItem('doctorId', this.doctorId);
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>
