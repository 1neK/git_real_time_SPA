
<template>
<v-container>
<v-layout>
    <v-flex xs12 sm6 offset-sm3>
        <v-card class="text-xs-center">
            <v-card-title primary-title>
                <div>
                    <h2> Login </h2>
                </div>
            </v-card-title>
         <v-form @submit.prevent="login">

          <v-text-field
            v-model="form.email"
            label="Email"
            type="email"
            required
          ></v-text-field>

        <v-text-field
            v-model="form.password"
            type="password"
            label="Password"
            required
          ></v-text-field>

  <v-btn color="blue-grey" type="submit">Login</v-btn>
  <router-link to="/signup"><v-btn color="light">Sign Up</v-btn></router-link>
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
.container {
  max-width: 960px;
}
</style>
