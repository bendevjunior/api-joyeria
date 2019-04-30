require('./bootstrap');

window.Vue = require('vue');
import router from './routes/routers';
import store from './vuex/store';

/**
* Components globais vue
*/
Vue.component('admin-component' , require('./components/admin/AdminComponent').default);

const app = new Vue({
    router , 
    store,
    el: '#app',
});
