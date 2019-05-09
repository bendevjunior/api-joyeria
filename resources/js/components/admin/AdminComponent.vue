<template>
    <div>
        <ul>
            <li>
                <router-link :to="{name: 'admin.dashboard'}">Dashboard</router-link>
                
            </li>
            <li>
                 <router-link :to="{name: 'admin.produtos'}">Produtos</router-link>
            </li>
        </ul>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        
    }
</script>

<style lang="scss" scoped>

</style>