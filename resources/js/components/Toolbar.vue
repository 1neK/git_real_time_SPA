<template>
    <v-toolbar>
        <div id="app">
            <v-app id="inspire" dark>
                <v-spacer></v-spacer>
                <v-toolbar app fixed clipped-left>
                   <!-- <v-toolbar-side-icon v-if="loggedIn" class="white--text"  @click.stop="drawer = !drawer"></v-toolbar-side-icon>-->
                    <v-toolbar-title>
                        <router-link class="white--text" to="/"></router-link>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <app-notification v-if="loggedIn"></app-notification>
                    <div class="hidden-sm-and-down" >
                        <v-menu offset-y>
                        <template v-slot:activator="{ on }">
                            <v-btn
                            icon slot="activator"
                            dark
                            v-on="on"
                            >
                                <v-icon>menu</v-icon>
                            </v-btn>
                        </template>
                        <v-list dense>
                            <v-list-tile
                            v-for="item in items"
                            :key="item.title"
                            :to="item.to"
                            v-if="item.show" >
                                <v-list-tile-title>
                                    {{item.title}}
                                </v-list-tile-title>
                            </v-list-tile>
                        </v-list>
                        </v-menu>
                    </div>

                </v-toolbar>
            </v-app>
        </div>
    </v-toolbar>
</template>

<script>
import AppNotification from './AppNotification'
export default {
    components:{AppNotification},
    data(){
        return {
            drawer: false,
            loggedIn : User.loggedIn(),
            items:[

                   { 'title':'Forum',to:'/forum',show:true },
                   { 'title':'Ask Question',to:'/ask',show:User.loggedIn() },
                   { 'title':'Category',to:'/category',show:User.admin() },
                   { 'title':'Login',to:'/login',show:!User.loggedIn() },
                   { 'title':'Logout',to:'/logout',show:User.loggedIn() },
                   /*{ 'title':'Designer',to:'/logout',show:User.designer() },
                   { 'title':'Admin',to:'/logout',show:User.admin() },
                   { 'title':'Coordinator',to:'/logout',show:User.coordinator() }*/
            ]

        }

    },
      created(){


            EventBus.$on('logout',()=>{
                User.logout()
            })
        }
}
</script>

<style>

</style>
