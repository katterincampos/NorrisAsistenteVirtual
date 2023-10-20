<template>
  <div class="container text-center">
    <div class="row">
      <input class="form-control" type="text" v-model="search" placeholder="Buscar usuario" style="border-radius:12px;">

      <table class="table" style="border: 1px solid black; border-collapse: collapse;">
        <tr v-for="user in filteredUsers" :key="user.id">
          <td style="border: 1px solid black;" class="col col-md-2">
            <img v-if="user.patient.imagen_perfil" :src="user.patient.imagen_perfil" alt="Foto de perfil" style="max-width: 100px; height: 100px; border-radius: 8px;"/>
            <img v-else src="../../../public/img/person-circle.svg" alt="Imagen predeterminada" />
          </td>
          <td style="border: 1px solid black;" class="col col-md-3">{{ user.patient.name }}</td>
          <td style="border: 1px solid black;" class="col col-md-2">{{ user.patient.email }}</td>
          <td style="border: 1px solid black;" class="col col-md-1">
            <button style="border:none !important;" @click="chatWith(user)">
              <img src="../../../public/img/chat-dots-fill.svg" alt=""> Chatear
            </button>
          </td>
          <td style="border: 1px solid black;" class="col col-md-2">
            <button style="border:none !important;" @click="viewStats(user)">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30" height="30">
                <path d="M32 32c17.7 0 32 14.3 32 32V400c0 8.8 7.2 16 16 16H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H80c-44.2 0-80-35.8-80-80V64C0 46.3 14.3 32 32 32zM160 224c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32s-32-14.3-32-32V256c0-17.7 14.3-32 32-32zm128-64V320c0 17.7-14.3 32-32 32s-32-14.3-32-32V160c0-17.7 14.3-32 32-32s32 14.3 32 32zm64 32c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32s-32-14.3-32-32V224c0-17.7 14.3-32 32-32zM480 96V320c0 17.7-14.3 32-32 32s-32-14.3-32-32V96c0-17.7 14.3-32 32-32s32 14.3 32 32z"/>
              </svg>
              Sintomas
            </button>
          </td>
          <td style="border: 1px solid black;" class="col col-md-3">
            <button style="border:none !important;" @click="viewSigs(user)">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30" height="30">
                <path d="M32 32c17.7 0 32 14.3 32 32V400c0 8.8 7.2 16 16 16H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H80c-44.2 0-80-35.8-80-80V64C0 46.3 14.3 32 32 32zM160 224c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32s-32-14.3-32-32V256c0-17.7 14.3-32 32-32zm128-64V320c0 17.7-14.3 32-32 32s-32-14.3-32-32V160c0-17.7 14.3-32 32-32s32 14.3 32 32zm64 32c17.7 0 32 14.3 32 32v96c0 17.7-14.3 32-32 32s-32-14.3-32-32V224c0-17.7 14.3-32 32-32zM480 96V320c0 17.7-14.3 32-32 32s-32-14.3-32-32V96c0-17.7 14.3-32 32-32s32 14.3 32 32z"/>
              </svg>
              Signos Vitales
            </button>
          </td>
        </tr>
      </table>
    </div>
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
      return this.users.filter(user => user.patient.name.includes(this.search) || user.patient.email.includes(this.search));
    }
  },
  methods: {
    viewSigs(user) {
      localStorage.setItem('patientId', user.patient.id);
      localStorage.setItem('patientName', user.patient.name);
      window.location.href = '/Gsignos';
    },
    viewStats(user) {
      localStorage.setItem('patientId', user.patient.id);
      localStorage.setItem('patientName', user.patient.name);
      window.location.href = '/Gsintomas';
    },
    chatWith(user) {
      localStorage.setItem('patientId', user.patient.id);
      localStorage.setItem('patientName', user.patient.name);
      localStorage.setItem('imgURL',user.patient.imagen_perfil);
      window.location.href = '/chatD';
    }
  },
  mounted() {
    const userId = localStorage.getItem('userId');
    axios.get(`/api/doctors/${userId}/patients`)
      .then(response => {
        console.log(response.data);
        this.users = response.data;
      });
  }
}
</script>
