<template>

    <div>
        <toolbar></toolbar>


 <v-layout row wrap>

                <navbar ></navbar>


                <router-view  ></router-view>

 </v-layout>

        <app-footer></app-footer>
    </div>


</template>

<script>
    import toolbar from './layouts/Toolbar'
    import AppFooter from './layouts/AppFooter'
    import navbar from './layouts/Navbar'
    import Login from './login/Login'

    export default {
        components: {toolbar, navbar, AppFooter, Login},


    }

</script>

<style>
    .rou {
        height: 100%;
        width: 100%;
    }

</style>
