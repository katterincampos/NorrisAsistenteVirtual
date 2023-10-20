const express = require('express'),
  server = express(),
  http = require('http').Server(server),
  io = require('socket.io')(http, {
    allowEIO3: true,
    cors: {
      origin: ['http://127.0.0.1:8000', 'http://localhost:8000'],
      credentials: true,
    },
  }),
  { MongoClient } = require('mongodb'),
  multer = require('multer'),
  cors = require('cors'),
  url = 'mongodb://127.0.0.1:27017/',
  dbname = 'norrisDB',
  client = new MongoClient(url),
  port = 3000,
  storage = multer.diskStorage({
    destination: 'uploads/',
    filename: (req, file, cb) => {
      cb(null, Date.now() + '-' + file.originalname);
    }
  }),
  upload = multer({
    storage: storage,
    fileFilter: (req, file, cb) => {
      if (file.mimetype.startsWith('image/')) {
        cb(null, true);
      } else {
        cb(new Error('Tipo de archivo no permitido'), false);
      }
    },
  });

// Función para conectar a la base de datos
async function conectarBD() {
  await client.connect();
  return client.db(dbname);
}

server.use(cors());
server.use(express.json());
server.use(express.urlencoded({ extended: true }));
server.use('/uploads', express.static('uploads')); // Para servir imágenes estáticas

// Ruta para actualizar datos del médico
server.post('/updateDoctor', async (req, res) => {
    try {
        const { id, name, email, username, address, city, zip_code, profileImage } = req.body;
        let db = await conectarBD(),
            collection = db.collection('doctors');

        // Actualizar o insertar datos del médico en MongoDB
        await collection.updateOne(
            { _id: id },
            {
                $set: {
                    name: name,
                    email: email,
                    username: username,
                    address: address,
                    city: city,
                    zip_code: zip_code,
                    profileImage: profileImage
                }
            },
            { upsert: true }
        );

        res.status(200).send('Datos del médico actualizados con éxito');
    } catch (error) {
        console.error(error);
        res.status(500).send('Error al actualizar los datos del médico');
    }
});

// Ruta para cargar la foto de perfil del médico
server.post('/uploadProfileImage', upload.single('profileImage'), (req, res) => {
    if (!req.file) {
        return res.status(400).send('No se cargó ninguna imagen');
    }
    res.status(200).send({ imagePath: `/uploads/${req.file.filename}` });
});

// Ruta para cargar archivos (mensajes)
server.post('/upload', upload.single('file'), (req, res) => {
  if (!req.file) {
    return res.status(400).send('No se cargó ningún archivo');
  }
  res.status(200).send('Archivo cargado con éxito');
});

// Ruta para obtener el último mensaje
server.get('/lastMessage/:chatId', async (req, res) => {
  try {
    const chatId = req.params.chatId;
    let db = await conectarBD(),
      collection = db.collection('chat');
    let lastMessage = await collection.find({ chatId: chatId }).sort({ fecha: -1 }).limit(1).toArray();
    res.json(lastMessage[0]);
  } catch (error) {
    console.error(error);
    res.status(500).send('Error al obtener el último mensaje');
  }
});

io.on('connect', (socket) => {
  socket.on('chat', async (chat) => {
    let db = await conectarBD(),
      collection = db.collection('chat');
    chat.status = 'enviado';
    chat._id = chat.messageId;
    const result = await collection.insertOne(chat);
    io.to('chat_' + chat.from + '_' + chat.to).emit('chat', chat);
    io.to('chat_' + chat.to + '_' + chat.from).emit('chat', chat);
  });

  // Manejador de eventos historial
  socket.on('historial', async ({ userId, chatId }) => {
    let db = await conectarBD(),
        collection = db.collection('chat'),
        chat = await collection.find({ chatId: chatId }).toArray();
    socket.emit('historial', chat);
  });

  // Otros manejadores de eventos...
});

http.listen(port, () => {
  console.log('Server corriendo en el puerto ', port);
});
