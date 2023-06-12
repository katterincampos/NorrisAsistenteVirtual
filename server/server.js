const express = require('express'),
    server = express(),
    http = require('http').Server(server),
    io = require('socket.io')(http, {
        allowEIO3:true,
        cors:{
            origin: ['http://127.0.0.1:8000', 'http://localhost:8000'],
            credentials:true,
        }
    }),
    { MongoClient } = require('mongodb'),
    url = 'mongodb://127.0.0.1:27017/',
    dbname = 'norrisDB',
    client = new MongoClient(url),
    port = 3000;

// Función para conectar a la base de datos
async function conectarBD(){
    await client.connect();
    return client.db(dbname);
}

server.use(express.json());

// Cuando un cliente se conecta al servidor
io.on('connect', socket => {
  console.log('server conectado...');

  // Cuando un usuario se conecta, lo agregamos a la sala de su chat
  socket.on('userConnected', ({ userId, chatId }) => {
    socket.join('chat_' + userId + '_' + chatId);
  });

  // Cuando recibimos un mensaje de chat de un cliente
  socket.on('chat', async chat => {
    let db = await conectarBD(),
        collection = db.collection('chat');
    chat.status = 'enviado'; // Marcamos el mensaje como enviado
    collection.insertOne(chat);

    // Emitimos el mensaje solo a los usuarios involucrados en el chat
    io.to('chat_' + chat.from + '_' + chat.to).emit('chat', chat);
    io.to('chat_' + chat.to + '_' + chat.from).emit('chat', chat);
  });

  // Cuando recibimos una solicitud de historial de chat de un cliente
  socket.on('historial', async ({ userId, chatId }) => {
    let db = await conectarBD(),
        collection = db.collection('chat'),
        chat = await collection.find({ chatId: chatId }).toArray();
    socket.emit('historial', chat); // Enviamos el historial al cliente que lo solicitó
  });

  // Cuando recibimos una confirmación de que un mensaje ha sido recibido por un cliente
  socket.on('messageReceived', async ({ messageId }) => {
    let db = await conectarBD(),
        collection = db.collection('chat');
    // Actualizamos el estado del mensaje en la base de datos
    await collection.updateOne({ _id: messageId }, { $set: { status: 'recibido' } });
  });

  // Cuando recibimos una confirmación de que un mensaje ha sido leído por un cliente
  socket.on('messageRead', async ({ messageId }) => {
    let db = await conectarBD(),
        collection = db.collection('chat');
    // Actualizamos el estado del mensaje en la base de datos
    await collection.updateOne({ _id: messageId }, { $set: { status: 'leido' } });
  });
});

http.listen(port, ()=>{
    console.log('Server corriendo en el puerto ', port);
});
