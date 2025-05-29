<template>
  <div class="bg-white p-6 rounded-xl shadow-md flex items-center space-x-4">
    <div v-if="weather" class="flex items-center space-x-4">
      <img :src="iconUrl" :alt="weather.weather[0].description" class="w-16 h-16 animate-pulse" />
      <div>
        <h3 class="text-xl font-semibold">Current Weather</h3>
        <p class="text-gray-600">{{ weather.name }}</p>
        <p class="text-3xl font-bold">{{ Math.round(weather.main.temp) }}°C</p>
        <p class="capitalize">{{ weather.weather[0].description }}</p>
      </div>
    </div>
    <div v-else class="text-gray-500">Loading weather...</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      weather: null,
      apiKey: 'bd5e378503939ddaee76f12ad7a97608',
      defaultLocation: { lat: 51.5074, lon: -0.1278 }, // London coordinates
      refreshInterval: null,
      refreshTimeMs: 5 * 60 * 1000 // 5 minutes
    };
  },
  computed: {
    iconUrl() {
      if (!this.weather) return '';
      return `https://openweathermap.org/img/wn/${this.weather.weather[0].icon}@2x.png`;
    }
  },
  mounted() {
    this.getLocation();
    this.refreshInterval = setInterval(() => {
      this.getLocation();
    }, this.refreshTimeMs);
  },
  beforeUnmount() {
    if (this.refreshInterval) {
      clearInterval(this.refreshInterval);
    }
  },
  methods: {
    getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(this.fetchWeather, this.useDefaultLocation);
      } else {
        console.error('Geolocation is not supported by this browser.');
        this.useDefaultLocation();
      }
    },
    async fetchWeather(position) {
      const lat = position.coords.latitude;
      const lon = position.coords.longitude;
      await this.fetchWeatherData(lat, lon);
    },
    async useDefaultLocation() {
      console.warn('Using default location: London');
      await this.fetchWeatherData(this.defaultLocation.lat, this.defaultLocation.lon);
    },
    async fetchWeatherData(lat, lon) {
      try {
        const response = await fetch(
          `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&appid=${this.apiKey}`
        );
        if (!response.ok) throw new Error('Failed to fetch weather data');
        this.weather = await response.json();
      } catch (error) {
        console.error(error);
      }
    }
  }
};
</script>

<style scoped>
.animate-pulse {
  animation: pulse 2s infinite;
}
@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.6;
  }
}
</style>
