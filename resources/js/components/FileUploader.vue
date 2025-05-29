<template>
  <div>
    <label class="block text-gray-700 font-semibold mb-2">Upload File</label>
    <input 
      type="file" 
      :accept="acceptedTypes" 
      @change="onFileChange" 
      class="block w-full text-sm text-gray-500
        file:mr-4 file:py-2 file:px-4
        file:rounded file:border-0
        file:text-sm file:font-semibold
        file:bg-blue-50 file:text-blue-700
        hover:file:bg-blue-100"
    />
    <div v-if="fileName" class="mt-2 text-gray-600 text-sm">
      Selected file: {{ fileName }}
      <button 
        type="button" 
        @click="removeFile" 
        class="ml-2 text-red-600 hover:text-red-800 underline"
      >
        Remove
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FileUploader',
  props: {
    modelValue: {
      type: [File, null],
      default: null
    },
    acceptedTypes: {
      type: String,
      default: '.pdf,.xlsx,.xls,.csv'
    }
  },
  data() {
    return {
      file: null,
      fileName: ''
    };
  },
  watch: {
    modelValue: {
      immediate: true,
      handler(newVal) {
        if (newVal) {
          this.file = newVal;
          this.fileName = newVal.name || '';
        } else {
          this.file = null;
          this.fileName = '';
        }
      }
    }
  },
  methods: {
    onFileChange(event) {
      const selectedFile = event.target.files[0];
      if (selectedFile) {
        this.file = selectedFile;
        this.fileName = selectedFile.name;
        this.$emit('update:modelValue', selectedFile);
      }
    },
    removeFile() {
      this.file = null;
      this.fileName = '';
      this.$emit('update:modelValue', null);
      // Clear the input field
      const fileInput = this.$el.querySelector('input[type="file"]');
      if (fileInput) {
        fileInput.value = '';
      }
    }
  }
};
</script>