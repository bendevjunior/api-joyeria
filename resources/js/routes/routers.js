import Vue from 'vue';
import VueRouter from 'vue-router';

import AdminComponent from '../components/admin/AdminComponent.vue';
import ProdutosComponents from '../components/admin/pages/produtos/ProdutosComponents.vue';
import DashboardComponent from '../components/admin/pages/dashboard/DashboardComponent.vue';
import HomeComponent from '../components/frontend/pages/home/HomeComponent.vue';
import SiteComponent from '../components/frontend/SiteComponent';
Vue.use(VueRouter);



const routes = [
  
  { 
    path: '/' , 
    component: SiteComponent,
    children : [

      { path : '' , component: HomeComponent , name : 'home'},

    ]
  },
  {
    path : '/admin' , 
    component : AdminComponent,
    children : [

      { path: '' , component: DashboardComponent, name: 'admin.dashboard' },
      
      { path :  'produtos' , ProdutosComponents , name: 'admin.produtos' },

    ]
  },
  

]

const router = new VueRouter({
  routes 
})


export default router ;