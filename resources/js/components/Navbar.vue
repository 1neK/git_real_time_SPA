<template>
<v-navigation-drawer permanent  v-if="User.loggedIn()">
    <v-container class="clnav1">
        <v-list dense>
            <!--<v-list-tile-content>
                <v-list-tile-title></v-list-tile-title>
            </v-list-tile-content>-->

                    <v-list-tile-content>
                        <div class="center1" font-weight-bold>
                            <h1> <v-list-tile-title >{{role}} </v-list-tile-title> </h1>
                        </div>

                    </v-list-tile-content>
                    <v-divider></v-divider>

            <v-list-tile to="/">
                <v-list-tile-action>
                    <v-icon color="deep-purple lighten-4">home</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <div class="center1">
                        <v-list-tile-title>Home</v-list-tile-title>
                    </div>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile to="/team" v-if="User.admin()">
                <v-list-tile-action>
                    <v-icon color="deep-purple lighten-4">supervised_user_circle</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <div class="center1">
                        <v-list-tile-title>Teams</v-list-tile-title>
                    </div>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile to="/project" v-if="User.admin() || User.coordinator()">
                <v-list-tile-action>
                    <v-icon color="deep-purple lighten-4">work</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <div class="center1">
                        <v-list-tile-title>Projects</v-list-tile-title>
                    </div>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile to="/task" >
                <v-list-tile-action>
                    <v-icon color="deep-purple lighten-4">view_list</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <div class="center1">
                        <v-list-tile-title>Tasks</v-list-tile-title>
                    </div>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile to="/allusers" v-if="User.admin()">
                <v-list-tile-action>
                    <v-icon color="deep-purple lighten-4">supervisor_account</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <div class="center1">
                        <v-list-tile-title>Users</v-list-tile-title>
                    </div>
                </v-list-tile-content>
            </v-list-tile>

            <v-list-tile to="/dashboard">
                <v-list-tile-action>
                    <v-icon color="deep-purple lighten-4">dashboard</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <div class="center1">
                        <v-list-tile-title>Dashboard</v-list-tile-title>
                    </div>
                </v-list-tile-content>
            </v-list-tile>

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
            role :""

        }

    },
      created(){

        this.role =localStorage.getItem('role');


        }
}
</script>
<style>
.clnav1{
  background-color: #43425D; /* violet */
  border: #43425D;
  color: white;
  height: 100%;
  width: 100%;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  font-size: 12px;
  border-radius: 2px;
}

.center1{
    color:white;
    font-weight:500;
    font-size:13px;
    display:flex;
}

.primary--text{
    opacity:0.5;
    color:white;
}

</style>




