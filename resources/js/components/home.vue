<template>

    <div>
        <toolbar></toolbar>
        <v-container fluid grid-list-md style="padding:inherit;">
            <v-layout row-wrap>


                <navbar ></navbar>


                <router-view class="rou"></router-view>

            </v-layout>
        </v-container>

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
