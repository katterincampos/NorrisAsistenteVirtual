import { createApp } from 'vue'
import UsersTable from './components/UsersTable.vue';
import ChatComponent from './components/ChatComponent.vue'


createApp({
    components: {
        UsersTable,
        ChatComponent
    }
}).mount('#app');
