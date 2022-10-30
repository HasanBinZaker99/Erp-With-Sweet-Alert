
import './bootstrap';
import { createApp } from 'vue';
import CreateCart from './components/CreateCart.vue';
import MenuPermission from './components/MenuPermission';
import measureCart from "./components/measureCart";
import AddPurchase from "./components/AddPurchase";
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const app = createApp({});
app.component('create-cart', CreateCart);
app.component('menu-permission', MenuPermission);
app.component('measure-cart', measureCart);
app.component('add-purchase', AddPurchase);

app.mount('#app');

// const abc = createApp({});
// abc.component('create-purchases', CreatePurchase);
// abc.mount('#prc');

