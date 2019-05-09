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
                axios.get('http://juniorsilva.blog.br/joyaria.web/api/produto/show')
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