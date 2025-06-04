<template>
  <div class="mt-4 p-4 bg-gray-50 rounded">
    <span class="text-gray-700 font-semibold">Additional Fees</span>
    <div v-for="(fee, index) in venue.additional_fees" :key="index" class="mt-2 flex space-x-4">
      <label class="flex-1">
        <span class="text-gray-700">Fee Name</span>
        <input
          v-model="fee.name"
          type="text"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          required
        />
      </label>
      <label class="flex-1">
        <span class="text-gray-700">Amount ({{ currencySymbol }})</span>
        <input
          v-model.number="fee.amount"
          type="number"
          step="0.01"
          min="0"
          class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          required
        />
      </label>
      <button type="button" @click="$emit('remove-fee', index)" class="mt-6 text-red-600 hover:underline">
        Remove
      </button>
    </div>
    <button type="button" @click="$emit('add-fee')" class="mt-2 text-blue-600 hover:underline">Add Fee</button>
  </div>
</template>

<script>
export default {
  name: 'AdditionalFees',
  props: {
    venue: Object,
    currencySymbol: String,
  },
};
</script>
