<template>
  <div class="form-section">
    <label>Availability Slots</label>
    <div v-for="(slot, index) in form.availability" :key="index" class="slot-row">
      <input type="time" v-model="slot.start" />
      <input type="time" v-model="slot.end" />
      <button type="button" @click="removeSlot(index)">Remove</button>
    </div>
    <button type="button" @click="addSlot">Add Time Slot</button>
  </div>
</template>

<script setup>
defineProps(['form'])

function addSlot() {
  form.availability.push({ start: '', end: '' })
}
function removeSlot(index) {
  form.availability.splice(index, 1)
}
</script>

<style scoped>
.slot-row {
  display: flex;
  gap: 1rem;
  margin-bottom: 0.5rem;
}
</style>
