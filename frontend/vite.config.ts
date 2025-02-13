import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [react()],
  build: {
    rollupOptions: {
      output: {
        manualChunks(id) {
          if (id.includes('node_modules')) {
            return id.split('node_modules/')[1].split('/')[0];
          }
          if (id.includes('src')) {
            const src_folder = id.split('src/')[1];
            const [principal, ...folders] = src_folder.split('/')
            let output = folders.join('-')
            if (output) {
              output = output.split('.')[0]
            }

            return `${principal.split('.')[0]}-${output}`
          }
          return null; 
        }
      }
    }
  }
});