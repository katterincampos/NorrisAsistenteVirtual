
import { createApp } from 'vue'
import UsersTable from './components/UsersTable.vue';
import ChatComponent from './components/ChatComponent.vue';
import ChatPacientes from './components/ChatPacientes.vue';
import homeNorris from './components/homeNorris.vue';
import historialChat from './components/HistorialComponent.vue';
import graficoSintomas from './components/GraficoSintomas.vue'

createApp({
    components: {
        UsersTable,
        ChatComponent,
        ChatPacientes,
        homeNorris,
        historialChat,
        graficoSintomas
    }
}).mount('#app');
