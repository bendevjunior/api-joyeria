<template>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>..</th>
                    <th>..</th>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
 import axios from 'axios';
    export default {
       created () {
           this.loadProdutos()
       },
        methods: {
            loadProdutos () {
                axios.get('http://juniorsilva.blog.br/joyaria.web/api/produto/show'
                 , {
                     withCredentials: true,
      headers : {                  
          "Access-Control-Allow-Origin": "*",
          "Access-Control-Allow-Headers": "Authorization", 
          "Access-Control-Allow-Methods": "GET, POST, OPTIONS, PUT, PATCH, DELETE" ,
          "Content-Type": "application/json;charset=UTF-8"                   
      },})
                .then(response => {
                    console.log(response)
                })
                .catch(error =>  {
                    console.log(error)
                })
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>