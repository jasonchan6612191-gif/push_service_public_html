import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

export default defineConfig(({ mode }) => ({
  base: mode === "production" ? "/push_service_public_html/" : "./",
  plugins: [vue()],
  build: {
    rollupOptions: {
      input: "./index.html",
    },
  },
}));
