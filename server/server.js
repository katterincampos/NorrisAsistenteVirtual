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

async function conectarBD(){
    await client.connect();
    return client.db(dbname);
}

server.use(express.json());

io.on('connect', socket => {
  console.log('server conectado...');

  // Cuando un usuario se conecta, lo agregamos a la sala de su chat
  socket.on('userConnected', ({ userId, chatId }) => {
    socket.join('chat_' + userId + '_' + chatId);
  });

  socket.on('chat', async chat => {
    let db = await conectarBD(),
        collection = db.collection('chat');
    collection.insertOne(chat);

    // Emitimos el mensaje solo a los usuarios involucrados en el chat
    io.to('chat_' + chat.from + '_' + chat.to).emit('chat', chat);
    io.to('chat_' + chat.to + '_' + chat.from).emit('chat', chat);
  });

  socket.on('historial', async ({ userId, chatId }) => {
    let db = await conectarBD(),
        collection = db.collection('chat'),
        chat = await collection.find({ chatId: chatId }).toArray();
    console.log('Recuperando historial para chatId:', chatId); // Añade esta línea
    console.log('Mensajes recuperados:', chat); // Añade esta línea
    socket.emit('historial', chat); //solo a mi... 
  });
});

http.listen(port, ()=>{
    console.log('Server corriendo en el puerto ', port);
});
