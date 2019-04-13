<template>
<v-navigation-drawer permanent>
    <v-container>
        <v-list dense>
            <v-list-tile-content>
                <v-list-tile-title v-if="User.designer()">Designer</v-list-tile-title>
            </v-list-tile-content>
            <v-list-tile-content>
                <v-list-tile-title v-if="User.coordinator()">Coordinator</v-list-tile-title>
            </v-list-tile-content>
            <v-list-tile-content>
                    <v-list-tile-title v-if="User.admin()">Admin</v-list-tile-title>
            </v-list-tile-content>

            <v-divider></v-divider>

            <v-list-tile to="/">
                <v-list-tile-action>
                    <v-icon>home</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Home</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile to="/team">
                <v-list-tile-action>
                    <v-icon>supervised_user_circle</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Teams</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile to="/project">
                <v-list-tile-action>
                    <v-icon>work</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Projects</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile to="/task">
                <v-list-tile-action>
                    <v-icon>view_list</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Tasks</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile to="/allusers">
                <v-list-tile-action>
                    <v-icon>supervisor_account</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Users</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile to="/dashboard">
                <v-list-tile-action>
                    <v-icon>dashboard</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Dashboard</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>


            <!--<admin v-if="User.admin()">

            </admin>
            <designer v-if="User.designer()">

            </designer>
            <coordinator v-if="User.coordinator()">

            </coordinator>-->

</v-list>
    </v-container>
</v-navigation-drawer>
</template>

<script>
import Admin from './users/Admin';
import Coordinator from './users/Coordinator';
import Designer from './users/Designer';
export default {

    data(){
        return {
            drawer: false,
            User : User,

        }

    },
      created(){

          console.log(User.loggedIn());

        }
}
</script>


