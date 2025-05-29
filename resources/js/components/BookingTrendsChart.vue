<template>
  <div>
    <apexchart type="area" height="250" :options="chartOptions" :series="series" />
  </div>
</template>

<script>
import ApexCharts from 'apexcharts'
import VueApexCharts from 'vue3-apexcharts'

export default {
  components: {
    apexchart: VueApexCharts
  },
  data() {
    return {
      series: [{
        name: 'Bookings',
        data: []
      }],
      chartOptions: {
        chart: {
          id: 'booking-trends',
          animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800,
            animateGradually: {
              enabled: true,
              delay: 150
            },
            dynamicAnimation: {
              enabled: true,
              speed: 350
            }
          }
        },
        xaxis: {
          type: 'category',
          labels: {
            rotate: -45
          }
        },
        yaxis: {
          title: {
            text: 'Number of Bookings'
          }
        },
        stroke: {
          curve: 'smooth'
        },
        dataLabels: {
          enabled: false
        },
        tooltip: {
          enabled: true,
          shared: true,
          intersect: false
        }
      }
    }
  },
  async mounted() {
    await this.fetchBookingTrends()
  },
  methods: {
    async fetchBookingTrends() {
      try {
        const response = await this.$axios.get('/api/booking-trends')
        const data = response.data
        this.series[0].data = data.map(item => ({ x: item.date, y: item.count }))
      } catch (error) {
        console.error('Error fetching booking trends:', error)
      }
    }
  }
}
</script>

<style scoped>
</style>
