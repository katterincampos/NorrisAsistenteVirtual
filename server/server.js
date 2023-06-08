const express = require('express');
const cors = require('cors');
const http = require('http');
const socketIo = require('socket.io');
const mongoose = require('mongoose');

// Conexión a MongoDB
mongoose.connect('mongodb://127.0.0.1:27017/norrisDB', { useNewUrlParser: true, useUnifiedTopology: true })
  .then(() => console.log('Conexión a MongoDB exitosa'))
  .catch(err => console.error('No se pudo conectar a MongoDB', err));

// Modelo de mensaje para MongoDB
const Message = mongoose.model('Message', new mongoose.Schema({
  user: String,
  text: String,
}));

const app = express();
const server = http.createServer(app);
const io = socketIo(server, {
    cors: {
      origin: "*", // Permitir todas las solicitudes CORS
      methods: ["GET", "POST"], // Permitir métodos GET y POST
    },
  });
app.use(cors());
io.on('connection', (socket) => {
  console.log('Un usuario se ha conectado');

  // Enviar los mensajes existentes al cliente
  Message.find().then(messages => {
    socket.emit('messages', messages);
  });

  // Escuchar nuevos mensajes del cliente
  socket.on('newMessage', (message) => {
    // Guardar el mensaje en la base de datos
    const messageDoc = new Message(message);
    messageDoc.save().then(() => {
      // Enviar el mensaje a todos los clientes
      io.emit('newMessage', message);
    });
  });

  socket.on('disconnect', () => {
    console.log('Un usuario se ha desconectado');
  });
});

const port = process.env.PORT || 3000;
server.listen(port, () => console.log(`Servidor escuchando en el puerto ${port}`));
