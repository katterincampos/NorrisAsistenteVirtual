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

// Middleware de autenticación
async function authMiddleware(socket, next) {
    const token = socket.handshake.auth.token;
    if (!token) {
        return next(new Error('Authentication error'));
    }

    // Aquí puedes verificar el token con tu método de autenticación
    // Por ejemplo, puedes buscar el token en tu base de datos y verificar si el usuario existe
    let db = await conectarBD(),
        collection = db.collection('users'),
        user = await collection.findOne({ token: token });

    if (!user) {
        return next(new Error('Authentication error'));
    }

    // Si la autenticación es exitosa, puedes almacenar el usuario en el socket para su uso posterior
    socket.user = user;

    next();
}

server.use(express.json());

io.use(authMiddleware);

io.on('connect', socket => {
  console.log('server conectado...');

  // Cuando un usuario se conecta, lo agregamos a la sala de su chat
  socket.on('userConnected', ({ userId, chatId }) => {
    socket.join('chat_' + userId + '_' + chatId);
  });

  // Resto del código...
});

http.listen(port, ()=>{
    console.log('Server corriendo en el puerto ', port);
});
