<template>
  <div class="p-4 bg-gray-50 rounded">
    <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
    <label class="block">
      <span class="text-gray-700 font-semibold">Venue Name</span>
      <input
        v-model="venue.name"
        type="text"
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
        required
      />
    </label>
    <label class="block mt-4">
      <span class="text-gray-700 font-semibold">Venue Type</span>
      <select
        v-model="venue.type"
        @change="$emit('update-facilities')"
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
        required
      >
        <option disabled value="">Select Venue Type</option>
        <option v-for="type in venueTypeOptions" :key="type" :value="type">
          {{ formatTypeName(type) }}
        </option>
      </select>
    </label>
    <label class="block mt-4">
      <span class="text-gray-700 font-semibold">Currency</span>
      <select
        v-model="venue.currency"
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
        required
      >
        <option v-for="currency in availableCurrencies" :key="currency.code" :value="currency.code">
          {{ currency.code }} ({{ currency.symbol }})
        </option>
      </select>
    </label>
  </div>
</template>

<script>
export default {
  name: 'BasicInformation',
  props: {
    venue: Object,
    venueTypeOptions: Array,
    availableCurrencies: Array,
  },
  methods: {
    formatTypeName(name) {
      return name.replace(/_/g, ' ').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
    },
  },
};
</script>
