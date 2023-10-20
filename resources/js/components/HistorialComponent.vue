<template>
  <div class="container ">
    <div class="row">
      <input class="form-control" type="text" v-model="search" placeholder="Buscar usuario" style="border-radius:12px;">
      <table class="table mt-1" style="border-left: 1px solid #000; border-top: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000; padding: 3rem 0; background-color: #fff;  box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);">
        <tr v-for="user in filteredUsers" :key="user.id">
          <td class="col col-md-3" style="cursor: pointer; border-bottom: 1px solid #000; border-right: 1px solid #000;" @click="chatWith(user)">
            <div class="row">
              <div class="col col-md-3">
                <img src="../../../public/img/undraw_pic_profile_re_7g2h.svg" alt="">
              </div>
              <div class="col col-md-6 mb-2 ml-0">
                <div>{{ user.patient.name }}</div>
                <div>{{ lastMessages[`chat_${userId}_${user.patient.id}`] || 'No hay mensajes' }}</div>
              </div>
            </div>
          </td>
          <td class="col col-md-9"></td>
        </tr>
      </table>
      <p v-if="filteredUsers.length === 0 && search" class="text-center mt-3">
        No se ha encontrado ninguna coincidencia.
      </p>
    </div>
  </div>
</template>


<script>
import axios from 'axios';

export default {
  data() {
    return {
      users: [],
      search: '',
      lastMessages: {}, // Objeto para almacenar los últimos mensajes por chatId
      userId: null // ID del usuario actual
    };
  },
  computed: {
    filteredUsers() {
      return this.users.filter(user => user.patient.name.includes(this.search) || user.patient.email.includes(this.search));
    }
  },
  methods: {
    viewStats(user) {
      // Lógica para ver las estadísticas del usuario
    },
    chatWith(user) {
      localStorage.setItem('patientId', user.patient.id);
      localStorage.setItem('patientName', user.patient.name);
      window.location.href = '/chatD';
    },
    async getLastMessage(chatId) {
      try {
        const response = await axios.get(`http://127.0.0.1:3000/lastMessage/${chatId}`);
        this.lastMessages[chatId] = response.data.message; // Almacenar el mensaje en la variable
      } catch (error) {
        console.error('Error al obtener el último mensaje:', error);
      }
    }
  },
  mounted() {
    this.userId = localStorage.getItem('userId'); // Obtener el userId
    axios.get(`/api/doctors/${this.userId}/patients`)
      .then(response => {
        this.users = response.data;
        this.users.forEach(user => {
          const chatId = `chat_${this.userId}_${user.patient.id}`;
          this.getLastMessage(chatId); // Llamar a getLastMessage para cada usuario
        });
      });
  }
}
</script>
