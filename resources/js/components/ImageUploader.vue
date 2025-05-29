<template>
  <div>
    <label class="block text-gray-700 font-semibold mb-2">Upload Images</label>
    <input 
      type="file" 
      multiple 
      accept="image/*" 
      @change="onFileChange" 
      class="block w-full text-sm text-gray-500
        file:mr-4 file:py-2 file:px-4
        file:rounded file:border-0
        file:text-sm file:font-semibold
        file:bg-blue-50 file:text-blue-700
        hover:file:bg-blue-100"
    />
    <div class="mt-2 flex flex-wrap gap-2">
      <div 
        v-for="(item, index) in displayItems" 
        :key="item.id || index" 
        class="relative w-24 h-24 border rounded overflow-hidden shadow-sm"
      >
        <img 
          :src="item.preview" 
          alt="Image preview" 
          class="object-cover w-full h-full" 
        />
        <button 
          type="button" 
          @click="removeImage(index)" 
          class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700 transition"
        >
          ×
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    modelValue: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      displayItems: [] // Array of {file, preview, id, isUrl} objects
    };
  },
  watch: {
    modelValue: {
      immediate: true,
      handler(newVal) {
        // Clean up old object URLs
        this.displayItems.forEach(item => {
          if (item.preview && item.preview.startsWith('blob:')) {
            URL.revokeObjectURL(item.preview);
          }
        });

        // Create new display items
        this.displayItems = newVal.map((file, index) => {
          if (typeof file === 'string') {
            return {
              file: file,
              preview: file,
              id: `url-${index}`,
              isUrl: true
            };
          } else {
            return {
              file: file,
              preview: URL.createObjectURL(file),
              id: `file-${index}-${Date.now()}`,
              isUrl: false
            };
          }
        });
      }
    }
  },
  methods: {
    onFileChange(event) {
      const selectedFiles = Array.from(event.target.files);
      const newItems = selectedFiles.map(file => ({
        file: file,
        preview: URL.createObjectURL(file),
        id: `file-${Date.now()}-${Math.random()}`,
        isUrl: false
      }));

      this.displayItems.push(...newItems);
      this.emitUpdate();
      
      // Clear the input
      event.target.value = '';
    },
    
    removeImage(index) {
      const item = this.displayItems[index];
      
      // Clean up object URL if it's a blob
      if (item.preview && item.preview.startsWith('blob:')) {
        URL.revokeObjectURL(item.preview);
      }
      
      this.displayItems.splice(index, 1);
      this.emitUpdate();
    },
    
    emitUpdate() {
      const files = this.displayItems.map(item => item.file);
      this.$emit('update:modelValue', files);
    }
  },
  
  beforeUnmount() {
    // Clean up object URLs when component is destroyed
    this.displayItems.forEach(item => {
      if (item.preview && item.preview.startsWith('blob:')) {
        URL.revokeObjectURL(item.preview);
      }
    });
  }
};
</script>