import "./bootstrap";
import "../css/app.css";
// import '@datatables.net-dt/css/jquery.dataTables.css';
// import { route } from 'ziggy-js';

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import axios from "axios"; // Import Axios
import store from "./store";
// Set CSRF Token for Axios from the meta tag
axios.defaults.headers.common["X-CSRF-TOKEN"] = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
      // Ambil `user` dari props paling awal
      const user = props.initialPage.props.auth?.user; // Optional chaining jika auth kosong
      if (user) {
          console.log("User dari props:", user);
          store.commit('SET_USER', user); // Set `user` ke `store` paling awal
      } else {
          console.log("tidak");
      }

      // Lanjutkan dengan inisialisasi aplikasi setelah `user` disimpan
      const app = createApp({ render: () => h(App, props) })
          .use(plugin)
          .use(store)
          .mount(el);
  },
});
