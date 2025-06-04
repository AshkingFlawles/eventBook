<template>
  <div>
    <!-- Additional Features Toggle -->
    <div class="mt-4">
      <label class="flex items-center space-x-2">
        <input 
          type="checkbox" 
          :checked="showAdditionalFeatures" 
          @change="$emit('update:showAdditionalFeatures', $event.target.checked)" 
          class="rounded" 
        />
        <span class="text-gray-700 font-semibold">Include Additional Features</span>
      </label>
    </div>

    <!-- Additional Features Section -->
    <div v-if="showAdditionalFeatures">
      <div v-for="category in featureCategories" :key="category.name" class="mt-6 p-4 bg-gray-50 rounded">
        <h3 class="text-lg font-semibold text-gray-700">{{ category.name }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
          <label v-for="feature in category.features" :key="feature.name" class="flex items-center space-x-2">
            <input
              :type="feature.type === 'checkbox' ? 'checkbox' : 'number'"
              v-model="venue[feature.name]"
              class="rounded"
              :min="feature.type === 'number' ? 0 : null"
            />
            <i :class="feature.icon" class="fa-lg text-blue-600"></i>
            <span class="text-gray-700">{{ formatFeatureName(feature.name) }}</span>
          </label>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdditionalFeatures',
  props: {
    venue: Object,
    showAdditionalFeatures: Boolean,
    featureCategories: Array,
    formatFeatureName: Function,
  },
  emits: ['update:showAdditionalFeatures'],
};
</script>
