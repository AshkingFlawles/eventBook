import { App } from 'vue';
import ImageUploader from '../components/ImageUploader.vue';
import FileUploader from '../components/FileUploader.vue';

export default {
  install(app) {
    app.component('ImageUploader', ImageUploader);
    app.component('FileUploader', FileUploader);
  }
};
