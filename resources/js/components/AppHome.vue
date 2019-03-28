<template>

<div>
        <toolbar></toolbar>
        <!-- <navbar></navbar> -->
         <router-view></router-view>
        <app-footer></app-footer>
</div>


</template>

<script>
import toolbar from './Toolbar'
import AppFooter from './Appfooter'
//import navbar from './Navbar'
import Login from './login/Login'
export default {
 components:{toolbar,AppFooter,Login}
}
</script>

<style>

</style>
