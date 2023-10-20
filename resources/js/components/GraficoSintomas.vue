<template>
  <div>
    <div v-if="loading">
      Cargando...
    </div>
    <div v-else>
      <h2>Evolución de síntomas de {{ user.name }}</h2>
      <canvas ref="myChart"></canvas>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import * as Chart from 'chart.js';

export default {
  data() {
    return {
      loading: true,
      user: {},
      sintomas: [],
      chart: null,
      patientId: localStorage.getItem('patientId')
    };
  },
  props: {
    patientId:19 
  },
  async created() {
    try {
      const response = await axios.get(`/api/graficosS/${this.patientId}`);
      this.sintomas = response.data;
      if (this.sintomas.length > 0) {
        this.user = this.sintomas[0].user;
      }
      this.loading = false;
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  },
 mounted() {
    this.createChart();

},
  methods: {
    createChart() {
      const ctx = this.$refs.myChart.getContext('2d');
      this.chart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: this.sintomas.map(s => s.created_at),
          datasets: [
            {
              label: 'Dificultad para respirar',
              data: this.sintomas.map(s => s.dificultad_respirar),
              borderColor: '#3498db',
              fill: false
            },
            // ... (resto de los datasets)
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    }
  }
};
</script>
