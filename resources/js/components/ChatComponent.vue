<template>
  <div id="appDoctor" class="container">
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
  <button type="button" class="btn "><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-mic-fill" viewBox="0 0 16 16">
  <path d="M5 3a3 3 0 0 1 6 0v5a3 3 0 0 1-6 0V3z"/>
  <path d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5z"/>
</svg></button>
<EmojiPicker v-if="showEmojiPicker" @select="addEmoji" />
  <button @click="showEmojiPicker = !showEmojiPicker" type="button" class="btn ">  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-emoji-smile-fill" viewBox="0 0 16 16">
  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zM4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8z"/>
</svg></button>
  <button type="button" class="btn "><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
  <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
  <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
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
  text-align: end; /* Color de fondo para los mensajes del emisor */
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
  max-width: 40%;
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
import EmojiPicker from 'vue3-emoji-picker';
export default {
  components: {
    EmojiPicker
  },
  data() {
    return {
      showEmojiPicker: false,
      userId: localStorage.getItem('userId'),
      userName: localStorage.getItem('userName'),
      patientId: localStorage.getItem('patientId'),
      patientName: localStorage.getItem('patientName'),      
      chatId: 'chat_' + localStorage.getItem('userId') + '_' + localStorage.getItem('patientId'),
      newMessage: {
        from: localStorage.getItem('userId'),
        fromName: localStorage.getItem('userName'),
        to: localStorage.getItem('patientId'),
        toName: localStorage.getItem('patientName'),
        message: '',
        status: '', // en espera, enviado, recibido, leido
        fecha: new Date()
      },
      messages: [],
      socket: null,
    };
  },
  watch: {
    patientId: function(newPatientId, oldPatientId) {
      this.chatId = 'chat_' + this.userId + '_' + newPatientId;
      this.newMessage.to = newPatientId;
    },
    patientName: function(newPatientName, oldPatientName) {
      // Aquí puedes actualizar cualquier dato que dependa del 'patientName'
    }
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
      // Emitir el evento 'messageReceived' al servidor
      this.socket.emit('messageReceived', { messageId: message._id });
    });

    // Manejar el evento 'messageRead'
    this.socket.on('messageRead', (messageId) => {
      const message = this.messages.find(msg => msg._id === messageId);
      if (message) {
        message.status = 'leído';
      }
    });

    this.obtenerHistorial();

    this.socket.on('chat', chat => {
      this.messages.push(chat);
    });
  },
  methods: {
     addEmoji(emoji) {
      this.newMessage.message += emoji;
    },
    sendMessage() {
      if (this.newMessage.message != '') {
        this.newMessage.chatId = this.chatId;
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
    }
  }
}
</script>


