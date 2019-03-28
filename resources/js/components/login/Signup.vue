<template>
    <v-container>
  <v-form @submit.prevent="signup">

          <v-text-field
            id="name"
             v-model="form.name"
            type="text"
            name="name"
            required
          ></v-text-field>
   <span class="red--text" v-if="errors.name" >{{errors.name[0]}}</span>

          <v-text-field
            v-model="form.email"
            label="Email"
            type="email"
            required
          ></v-text-field>
  <span class="red--text" v-if="errors.email" >{{errors.email[0]}}</span>
        <v-text-field
            v-model="form.password"
            type="password"
            label="Password"
            required
          ></v-text-field>
   <span class="red--text" v-if="errors.password" >{{errors.password[0]}}</span>
        <v-text-field
            v-model="form.password_confirmation"
            type="password"
            label="Password"
            required
          ></v-text-field>

  <v-btn color="green" type="submit">Signup</v-btn>
  <router-link to="/login"><v-btn color="blue">Login</v-btn></router-link>
  </v-form>
  </v-container>
</template>

<script>
export default {
    data(){
        return{
            form:{
                name:null,
                email:null,
                password:null,
                password_confirmation:null
            },
            errors:{}

            }

    },
       created(){
            if(User.loggedIn()){
                this.$router.push({name:'forum'})
            }

        },

    methods:{
    validEmail: function (email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    },
     signup(){
         if (this.form.name && this.form.email && this.validEmail(this.form.email) ){
            axios.post('/api/auth/signup',this.form)
            .then(res => {
            User.responseAfterLogin(res)
            window.location='/forum'

        })
        .catch(error=>this.errors=error.response.data.errors)
         }



    }
}
}
</script>

<style>

</style>
