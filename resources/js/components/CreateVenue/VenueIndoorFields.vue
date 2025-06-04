<template>
  <div class="form-section">
    <h4>Indoor Settings</h4>
    <label>
      <input type="checkbox" v-model="form.indoor.ac" /> Air Conditioning
    </label>
    <label>
      <input type="checkbox" v-model="form.indoor.projector" /> Projector Available
    </label>
  </div>
</template>

<script setup>
defineProps(['form'])
</script>
