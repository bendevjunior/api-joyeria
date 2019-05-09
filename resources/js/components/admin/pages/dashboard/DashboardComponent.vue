<template>
    <div>
        Dashboard
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