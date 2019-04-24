
<template>
<v-container>
<v-layout>
    <v-flex xs12 sm6 offset-sm1>
        <v-card class="text-xs-center" id="card1">
            <v-card-title primary-title>
                <div class="center" font-weight-bold>
                    <h1> Login </h1>
                </div>
            </v-card-title>
         <v-form @submit.prevent="login">

          <v-text-field
            class="px-1"
            v-model="form.email"
            placeholder="Username"
            type="email"
            autofocus
            required
          ></v-text-field>

        <v-text-field
            class="px-1"
            v-model="form.password"
            type="password"
            placeholder="Password"
            required
          ></v-text-field>
          <v-flex xs12></v-flex>
          <v-flex xs12></v-flex>
          <v-html>
              <button class="button1" type="submit">Login</button> &nbsp;
              <router-link to="/signup"><button class="button2">Sign Up</button></router-link>
          </v-html>

          <v-flex xs12></v-flex>

  </v-form>
  </v-card>
    </v-flex>
</v-layout>
</v-container>
</template>


<script>

import User from '../../Helpers/User';
export default {
        data()
        {
            return {
                form :{
                    email:null,
                    password:null,
                }
            }
        },
        created(){

        },


        methods:{
            validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            login()
            {


                if(this.form.password && this.form.email && this.validEmail(this.form.email))
                User.login(this.form,this.$router)

            }

        }
}
</script>

<style>
#card1{
    padding: 50px 50px;
}
.container {
  max-width: 960px;

}
.center {
  margin: auto;
    color:#43425D;
}
.button1 {
  background-color: #43425D; /* Green */
  border: none;
  color: white;
  padding: 7px 40px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  font-size: 12px;
  border-radius: 2px;
}
.button2 {
  background-color: none; /* Green */
  border: 2px solid #43425D;
  color: #43425D;
  padding: 7px 40px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  font-size: 12px;
  border-radius: 2px;
}
</style>
