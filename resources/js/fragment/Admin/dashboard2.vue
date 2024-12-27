<template>
    <div>
      <highcharts :options="chartOptions"></highcharts>
    </div>
  </template>
  
  <script>
  // Import Highcharts jika belum diimpor
  import Highcharts from 'highcharts';
  import HighchartsVue from 'highcharts-vue';
  
  export default {
    name: 'MyChart', // Anda dapat memberi nama sesuai kebutuhan
    components: {
      highcharts: HighchartsVue.component,
    },
    data() {
      return {
        chartOptions: {
          title: {
            text: 'Contoh Grafik dengan Highcharts'
          },
          series: [
            {
              type: 'line',
              name: 'Contoh Data',
              data: [1, 2, 3, 4, 5]
            }
          ]
        }
      };
    }
  };
  </script>