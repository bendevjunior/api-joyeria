import Vue from 'vue';
import VueRouter from 'vue-router';

import AdminComponent from '../components/admin/AdminComponent.vue';
import ProdutosComponents from '../components/admin/pages/produtos/ProdutosComponents.vue';
import DashboardComponent from '../components/admin/pages/dashboard/DashboardComponent.vue';

Vue.use(VueRouter);



const routes = [
  {
    path : '/admin' , 
    component : AdminComponent,
    children : [
      {
        path: '' , 
        component: DashboardComponent,
        name: 'admin.dashboard'
      },
      
      {
        path :  'produtos' ,
        component : ProdutosComponents ,
        name: 'admin.produtos' 
      } 
    ]
  },
  

]

const router = new VueRouter({
  routes 
})


export default router ;