<template>
    <div>
      <Bar :data="chartData" :options="chartOptions" />
    </div>
  </template>
  
  <script>
  import { Bar } from 'vue-chartjs'
  import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
  
  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
  function generateColors(count,alpha) {
  const colors = [];
  for (let i = 0; i < count; i++) {
    const shade = 240 - (i * (240 / count)); // Distribuir tonos de azul
    colors.push(`hsla(${shade}, 100%, 50%, ${alpha})`);
  }
  return colors;
}
  export default {
  components: {
    Bar,
  },
  props: {
    gastosPorCategoria: {
      type: Array,
      required: true,
    },
  },
  data() {
    const numBars = this.gastosPorCategoria.length;
    const barColors = generateColors(numBars, 0.5);

    return {
    
      chartData: {
        labels: this.gastosPorCategoria.map(item => item.nombre),
        datasets: [
          {
            label: '',
            backgroundColor: barColors, 
            borderColor: barColors,
            borderWidth: 1,
            data: this.gastosPorCategoria.map(item => item.total),
          },
        ],
      },
      chartOptions: {
        responsive: true,
        barThickness: 20
      },
      
    };
  },
  
};

  </script>