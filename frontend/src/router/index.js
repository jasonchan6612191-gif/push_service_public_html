import { createRouter, createWebHashHistory } from "vue-router";

// 載入路由對應的組件
import Home from "../views/Home.vue";
import About from "../views/About.vue";

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/about",
    name: "About",
    component: About,
  },
];

const router = createRouter({
  // GitHub Pages 建議使用 hash 模式避免 404
  history: createWebHashHistory(),
  routes,
});

export default router;
