<template>
  <div>
    <input type="text" v-model="search" placeholder="Buscar usuario">
    <table>
      <tr v-for="user in filteredUsers" :key="user.id">
        <td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
</svg></td>
        <td>{{ user.name }}</td>
        <td><button @click="viewStats(user)">Ver estadísticas</button></td>
        <td><button @click="chatWith(user)">Chatear</button></td>
      </tr>
    </table>
  </div>
</template>

<script>
import axios from 'axios'; 
export default {
  data() {
    return {
      users: [],
      search: ''
    }
  },
  computed: {
    filteredUsers() {
      return this.users.filter(user => user.name.includes(this.search));
    }
  },
  methods: {
    viewStats(user) {
      // Lógica para ver las estadísticas del usuario
    },
    chatWith(user) {
      // Lógica para chatear con el usuario
    }
  },
  mounted() {
    axios.get('/api/users')
      .then(response => {
        this.users = response.data;
      });
  }
}
</script>
