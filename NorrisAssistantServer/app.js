const express = require('express');
const OpenAI = require('openai');

const app = express();
const port = 3001;

const openai = new OpenAI({
    apiKey: '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'
});

app.use(express.json());

const epocKeywords = [
    'muerte','miedo','mejorar','EPOC','Norris','Hola', 'Enfisema', 'Bronquitis crónica', 'Pulmonar', 'Respiratorio', 'Broncodilatador',
    'Inhalador', 'Corticosteroide', 'Oxígeno', 'Neumología', 'Disnea', 'Sibilancias', 'Tos persistente',
    'Mucosidad', 'Exacerbación', 'Enfermedad progresiva', 'Fumador', 'Tabaco', 'Cigarrillo', 'Contaminación del aire',
    'Rehabilitación pulmonar', 'Ventilación', 'Espirometría', 'Capacidad pulmonar', 'Volumen espiratorio', 'Insuficiencia respiratoria',
    'Alvéolo', 'Bronquio', 'Tráquea', 'Inhalación', 'Exhalación', 'Medicación', 'Anticolinérgico', 'Broncoespasmo', 'Inflamación',
    'Obstrucción', 'Aire atrapado', 'Dificultad para respirar', 'Fatiga', 'Pérdida de peso', 'Debilidad muscular', 'Enfermedad cardíaca',
    'Hipertensión pulmonar', 'Edema', 'Cianosis', 'Diagnóstico', 'Tratamiento', 'Prevención', 'Síntoma', 'Pronóstico', 'Asma',
    'Infección respiratoria', 'Fisioterapia respiratoria', 'Esteroides', 'Antibióticos', 'Mucolítico', 'Expectorante', 'Vacuna antigripal',
    'Vacuna antineumocócica', 'Espirómetro', 'Prueba de función pulmonar', 'Radiografía de tórax', 'Tomografía computarizada', 'Gasometría arterial',
    'Oximetría de pulso', 'Índice de masa corporal', 'Desnutrición', 'Ejercicio', 'Actividad física', 'Nutrición', 'Dieta', 'Suplemento nutricional',
    'Desarrollo pulmonar', 'Tabaquismo pasivo', 'Humo de segunda mano', 'Contaminantes ambientales', 'Polución', 'Calidad del aire', 'Enfermedad pulmonar',
    'Enfermedad obstructiva', 'Enfermedad restrictiva', 'Fibrosis', 'Inflamación pulmonar', 'Hiperreactividad bronquial', 'Agudización', 'Crónico', 'Agudo',
    'Progresivo', 'Irreversible', 'Degenerativo', 'Incurable', 'Mortal', 'Letal', 'Grave', 'Serio', 'Complicado', 'Avanzado', 'Moderado', 'Leve', 'Severo',
    'Terminal', 'Estable', 'Inestable', 'Controlado', 'No controlado', 'Manejable', 'Inmanejable', 'Tratable', 'Intratable', 'Reversible', 'Irreversible',
    'Curable', 'Incurable', 'Prevenible', 'No prevenible', 'Evitable', 'Inevitable', 'Reducible', 'Irreducible', 'Mejorable', 'Irmejorable', 'Optimizable',
    'Subóptimo', 'Ideal', 'No ideal', 'Adecuado', 'Inadecuado', 'Suficiente', 'Insuficiente', 'Completo', 'Incompleto', 'Exacto', 'Inexacto', 'Preciso',
    'Impreciso', 'Específico', 'Inespecífico', 'Directo', 'Indirecto', 'Interno', 'Externo', 'Superior', 'Inferior', 'Mayor', 'Menor', 'Alto', 'Bajo',
    'Largo', 'Corto', 'Grande', 'Pequeño', 'Amplio', 'Estrecho', 'Profundo', 'Superficial', 'Pesado', 'Ligero', 'Duro', 'Blando', 'Fuerte', 'Débil',
    'Rápido', 'Lento', 'Nuevo', 'Viejo', 'Joven', 'Anciano', 'Adulto', 'Infantil', 'Masculino', 'Femenino', 'Sexual', 'Asexual', 'Reproductivo', 'No reproductivo',
    'Fértil', 'Infértil', 'Vivo', 'Muerto', 'Vital', 'No vital', 'Orgánico', 'Inorgánico', 'Natural', 'Artificial', 'Normal', 'Anormal', 'Regular', 'Irregular',
    'Constante', 'Variable','alfa-1 antitripsina','enfermedad','patologia'];


// Inicializar la cola de mensajes con el mensaje del sistema
const messageQueue = [{
    role: "system",
    content: "Eres Norris, un asistente virtual especializado en EPOC (Enfermedad Pulmonar Obstructiva Crónica). Tu propósito principal es responder preguntas relacionadas con la EPOC. Si recibes una pregunta ambigua, intenta relacionarla con la EPOC. Si la pregunta no está relacionada con la EPOC, informa al usuario que solo estás capacitado para ayudar con temas relacionados con la EPOC. Debes ser extremadamente amable, empático y considerado. No ofrezcas diagnósticos médicos ni recomendaciones de tratamiento. Siempre enfatiza la importancia de consultar con un profesional de la salud."
}];

app.post('/chat', async (req, res) => {
    try {
        const userMessage = {
            role: "user",
            content: req.body.user_message
        };
        
        // Añadir mensaje del usuario a la cola
        messageQueue.push(userMessage);

        // Comunicación con la API de OpenAI para obtener una respuesta del modelo
        const openaiResponse = await openai.chat.completions.create({
            model: 'gpt-4', // Asumiendo que estás usando GPT-4 aquí
            messages: messageQueue,
            temperature: 0.3,
            max_tokens: 1000,
        });

        const assistantMessage = {
            role: "assistant",
            content: openaiResponse.choices[0].message.content
        };

        // Añadir respuesta del asistente a la cola
        messageQueue.push(assistantMessage);

        // Asegurarse de que solo se mantengan los últimos 10 mensajes
        while (messageQueue.length > 10) {
            messageQueue.shift();
        }

        // Verificar que el mensaje del sistema sigue siendo el primero; si no, añadirlo de nuevo
        if (messageQueue[0].role !== "system") {
            messageQueue.unshift({
                role: "system",
                content: "Eres Norris, un asistente virtual..."
            });
        }

        res.status(200).json({ message: assistantMessage.content });
    } catch (error) {
        console.error(error);
        res.status(500).json({ message: 'Hubo un error al procesar tu solicitud' });
    }
});

app.listen(port, () => {
    console.log(`Norris Assistant Server is running at http://localhost:${port}`);
});