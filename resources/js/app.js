import './bootstrap';
import { createApp } from "vue";
import { createPinia } from 'pinia';
import App from "./app.vue";
import router from "./router";
import sidebar from "./components/sidebar.vue"
import theme from "./components/theme.vue"

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Cleave from 'vue-cleave-component';
import loading from "./components/loading.vue";

import pagination from "./components/pagination.vue";
import multiselect from '@vueform/multiselect';
import en from './locale/en.json';
import la from './locale/la.json';
import vn from './locale/vn.json';
import th from './locale/th.json';
import { createI18n } from "vue-i18n";
const i18n = createI18n({
  locale: 'en',
  messages: {
    en: en,
    la: la,
    vn: vn,
    th: th
  }
});

const pinia = createPinia();
const app = createApp(App);
app.use(router);
app.use(pinia);
app.use(i18n);
app.use(VueSweetalert2);
app.use(Cleave);
app.component('loading', loading);
app.component('sidebar', sidebar);
app.component('theme', theme);
app.component('pagination', pagination);
app.component('multiselect', multiselect);
app.mount("#app");