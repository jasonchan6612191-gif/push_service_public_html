import { createApp } from "vue";
import App from "./components/App.vue";
import i18n from "./utils/i18n.js";

const app = createApp(App);
app.use(i18n);
app.mount("#app");
