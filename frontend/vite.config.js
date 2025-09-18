import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
  base: "/ibubbleivlc/", // 直接是 GitHub Repo 名稱加斜線
  plugins: [vue()],
});
