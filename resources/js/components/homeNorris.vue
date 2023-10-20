<template>
  <div class="container text-center">
    <div class="container">
      <!-- Contenido principal de la página -->
      <div class="hero-section">
    <div class="hero-image col-lg-6">
        <img src="../../img/norris.jpg" alt="Imagen de ejemplo" class="img-fluid">
    </div>
    <div class="hero-text">
        <p class="h2">Bienvenid@s</p>
        <p>Hola, soy norris tu asistente virtual, mi objetivo es ayudar a personas con enfermedad obstructiva cronica</p>
    </div>
</div>

    </div>
  </div>
</template>

<script>
import axios from 'axios'; 
import alertify from 'alertifyjs';
export default {
  data() {
    return {
      doctorId: '',
      doctorName: '',
      doctorProfileImageUrl: '',
    }
  },
  methods: {
getDoctorData() {
  const userId = localStorage.getItem('userId');
  axios.get(`/api/patients/${userId}/doctors`)
    .then(response => {
      console.log(response.data); // Verificar la respuesta del servidor

      // Acceder al primer elemento del array y luego al objeto doctor
      const doctorData = response.data[0].doctor;
      if (!doctorData) {
        console.error("El objeto 'doctor' no está presente en la respuesta.");
        return;
      }

      this.doctorId = doctorData.id;
      this.doctorName = doctorData.name;
      const doctorProfileImageUrl = doctorData.profile_image_url;

      console.log(doctorProfileImageUrl); // Verificar el valor antes de guardarlo

      localStorage.setItem('doctor_id', this.doctorId);
      localStorage.setItem('doctorName', this.doctorName);
      localStorage.setItem('doctorProfileImageUrl', doctorProfileImageUrl);
    })
    .catch(error => {
      console.error(error);
    });
}

  },
  mounted() {
    this.getDoctorData();
    alertify.success("Inicio de sesion exitoso")
  }
}
</script>
