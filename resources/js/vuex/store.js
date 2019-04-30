import Vue from 'vue';
import Vuex from 'vuex';

import Produtos from './modules/produtos/produtos';

Vue.use(Vuex);

const store = new Vuex.Store({
    modules :{
        produto : Produtos
    }
});
export default store;