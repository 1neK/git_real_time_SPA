<template>
    <v-toolbar>
        <div id="app">
            <v-app id="inspire">
                <v-flex md8></v-flex>
                <v-flex md4>
                <v-toolbar app fixed clipped-left dark color="#3B3B53">
                   <!-- <v-toolbar-side-icon v-if="loggedIn" class="white--text"  @click.stop="drawer = !drawer"></v-toolbar-side-icon>-->
                    <v-toolbar-title>
                        <router-link class="white--text" to="/"></router-link>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <router-link class="font-weight-light subheading white--text" to="/login" v-if="!loggedIn">Login</router-link>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <router-link class="font-weight-light subheading white--text" to="/signup" v-if="!loggedIn">Sign Up</router-link>
                    <app-notification v-if="loggedIn"></app-notification>
                    <div class="hidden-sm-and-down" v-if="loggedIn">
                        <v-menu offset-y>
                        <template v-slot:activator="{ on }">
                            <v-btn
                            icon slot="activator"
                            dark
                            v-on="on"
                            >
                                <v-icon color="white">menu</v-icon>
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
                </v-flex>
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

                   { 'title':'Task Types',to:'/category',show:User.admin() },
                   { 'title':'Login',to:'/login',show:!User.loggedIn() },
                   { 'title':'Logout',to:'/logout',show:User.loggedIn() },

            ]

        }

    },
      created(){



            EventBus.$on('logout',()=>{
                User.logout()
            })
        },
    mounted() {

    }
}
</script>

<style>

</style>
