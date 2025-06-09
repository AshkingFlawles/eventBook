<template>
  <div class="form-section">
    <h4>Outdoor Settings</h4>
    <label>
      <input type="checkbox" v-model="form.outdoor.tent_available" /> Tent Available
    </label>
    <label>
      <input type="checkbox" v-model="form.outdoor.stage" /> Stage Setup
    </label>
  </div>
</template>

<script setup>
defineProps(['form'])
</script>
