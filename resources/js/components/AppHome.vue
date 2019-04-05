<template>

<div>
        <toolbar></toolbar>
        <v-container fluid grid-list-md >
        <v-layout row-wrap>
        <v-flex xs3>
        <navbar></navbar>
        </v-flex>
        <v-flex xs10>
        <router-view></router-view>
        </v-flex>
    </v-layout>
</v-container>
        <app-footer></app-footer>
</div>


</template>

<script>
import toolbar from './Toolbar'
import AppFooter from './Appfooter'
import navbar from './Navbar'
import Login from './login/Login'
export default {
 components:{toolbar,navbar,AppFooter,Login}
}
</script>

<style>

</style>
