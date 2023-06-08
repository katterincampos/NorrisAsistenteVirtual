<template>
  <!-- ... -->
  <div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Escribe un mensaje..." v-model="newMessage" @keyup.enter="sendMessage">
    <div class="input-group-append">
      <button class="btn btn-outline-secondary" type="button" id="button-addon2" @click="sendMessage">Enviar</button>
    </div>
  </div>
  <!-- ... -->
</template>

<script>
import io from 'socket.io-client';

export default {
  data() {
    return {
      newMessage: '',
      messages: [],
      socket: null,
    };
  },
  created() {
    this.socket = io('http://localhost:3000');

    this.socket.on('messages', (messages) => {
      this.messages = messages;
    });

    this.socket.on('newMessage', (message) => {
      this.messages.push(message);
    });
  },
  methods: {
    sendMessage() {
      this.socket.emit('newMessage', {
        user: 'Nombre usuario',
        text: this.newMessage,
      });
      this.newMessage = '';
    },
  },
};
</script>
