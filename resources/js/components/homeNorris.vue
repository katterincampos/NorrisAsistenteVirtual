<template>
  <div class="container text-center">
    <a href="/logout">Cerrar Sesion</a>
  </div>
</template>

<script>
import axios from 'axios'; 

export default {
  data() {
    return {
      doctorId: '',
      doctorName: '',
    }
  },
  methods: {
    getDoctorData() {
      const userId = localStorage.getItem('userId');
      axios.get(`/api/patients/${userId}/doctors`)
        .then(response => {
          this.doctorId = response.data[0].doctor_id;
          this.doctorName = response.data[0].doctorName;
          localStorage.setItem('doctor_id', this.doctorId);
          localStorage.setItem('doctorName', this.doctorName);
        })
        .catch(error => {
          console.error(error);
        });
    }
  },
  mounted() {
    this.getDoctorData();
  }
}
</script>
