import { createApp } from "vue";
import router from "./router";
import App from "./components/App.vue";
import HighchartsVue from "highcharts-vue";
import "@fortawesome/fontawesome-free/css/all.css";
// import '../../node_modules/flowbite-vue/dist/index.css'
import "vuetify/styles";
import { createVuetify } from "vuetify";
import { aliases, mdi } from "vuetify/iconsets/mdi";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import "@mdi/font/css/materialdesignicons.css";
import Header from './components/admin/Header.vue';
import Camera from './components/camera/Camera.vue';
import User from './components/user/index.vue';
import Userd from './components/NavBar_all.vue';
import UserPage from "./components/UserPage.vue";
import Dashboard from "./components/Dashboard.vue";



import axios from "axios";

// Set CSRF token in Axios headers
const csrfToken = document
  .querySelector('meta[name="csrf-token"]')
  .getAttribute("content");

axios.defaults.headers.common["X-CSRF-TOKEN"] = csrfToken;

const vuetify = createVuetify({
    components,
    directives,
});
const app = createApp(App);
app.use(router);
app.use(HighchartsVue);
app.use(vuetify);

app.component('Header', Header);
app.component('camera', Camera);
// app.component('User', User);
// app.component('Userd', Userd);
app.component('UserPage', UserPage);
app.component('Dashboard', Dashboard);

app.mount("#appvue");
