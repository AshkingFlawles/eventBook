<template>
  <div class="form-section">
    <label>Upload Venue Images</label>
    <input type="file" multiple accept="image/*" @change="handleImages" />

    <div class="preview-grid">
      <div v-for="(img, i) in form.images" :key="i" class="img-preview">
        <img :src="img.preview" width="100" />
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps(['form'])

function handleImages(e) {
  const files = Array.from(e.target.files)
  form.images = files.map(file => ({
    file,
    preview: URL.createObjectURL(file)
  }))
}
</script>

<style scoped>
.preview-grid {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}
.img-preview img {
  border: 1px solid #ccc;
}
</style>
