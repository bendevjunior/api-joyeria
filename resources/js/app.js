require('./bootstrap');

window.Vue = require('vue');
//Vue.component('example-component', require('./components/ExampleComponent.vue').default);


/**
* Components globais vue
*/
Vue.component('test-component' , require('./components/TestComponent.vue'));


const app = new Vue({
    el: '#app',
});
