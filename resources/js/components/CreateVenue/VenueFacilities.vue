<template>
  <div class="p-4 bg-gray-50 rounded">
    <h2 class="text-xl font-semibold mb-4">Facilities</h2>
    <div v-if="requiredFacilities.length > 0">
      <h3 class="font-semibold text-gray-700">Required Facilities</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
        <label
          v-for="facility in requiredFacilities"
          :key="facility"
          class="flex items-center space-x-2"
        >
          <input
            type="checkbox"
            :checked="venue.type !== 'custom' ? true : venue.facilities.includes(facility)"
            :disabled="venue.type !== 'custom'"
            v-model="venue.facilities"
            :value="facility"
            class="rounded"
          />
          <i :class="facilityIcons[facility]" class="fa-lg text-blue-600"></i>
          <span class="text-gray-700">{{ formatFeatureName(facility) }}</span>
        </label>
      </div>
    </div>
    <h3 class="font-semibold text-gray-700 mt-4">Optional Facilities</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
      <label
        v-for="facility in optionalFacilities"
        :key="facility"
        class="flex items-center space-x-2"
      >
        <input type="checkbox" v-model="venue.facilities" :value="facility" class="rounded" />
        <i :class="facilityIcons[facility]" class="fa-lg text-blue-600"></i>
        <span class="text-gray-700">{{ formatFeatureName(facility) }}</span>
      </label>
    </div>
  </div>
</template>

<script>
export default {
  name: 'VenueFacilities',
  props: {
    venue: Object,
    requiredFacilities: Array,
    optionalFacilities: Array,
    facilityIcons: Object,
    formatFeatureName: Function,
  },
};
</script>
