<template>

<div class="">

    <v-dialog  v-model="dialog"  width="500"  >

      <template v-slot:activator="{ on }">

          <v-card-text class="text-right" style="height: 100px; position: relative">

            <v-btn
             v-on="on"
              absolute
              dark
              fab
              top
              right
              color="pink"

            >
              <v-icon>add</v-icon>
            </v-btn>
          </v-card-text>
          <v-layout row wrap>
          <v-flex xs9 sm4  v-for="team in teams" :key="team.id">
            <v-card to="/liste_team">
              <v-card-title primary-title>
                <div>
                  <h3 class="headline mb-0">{{ team.name }}</h3>
                  <div>  task :  {{ team.task_number }} </div>
                  <div> users :  {{ team.user_number }} </div>
                </div>
              </v-card-title>
            <v-card-actions>
                <v-btn flat color="orange">edit</v-btn>

             </v-card-actions>
           </v-card>
          </v-flex>
  </v-layout>
      </template>

      <v-card>
            <v-form @submit.prevent="submit">
        <v-card-title
          class="headline grey lighten-2"
          primary-title
        >
          <v-icon x-large>supervised_user_circle</v-icon>
        </v-card-title>

        <v-card-text>

            <v-alert v-if="errors" type="error" :value="true" >
                Team name is required.
            </v-alert>



            <v-text-field
            label="Team Name"
            v-model="form.name"
            required ></v-text-field>


        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            flat
            @click="dialog = false"
          >
            close
          </v-btn>
           <v-btn type="submit" :disabled="disabled" color="cyan" v-if="editSlugt">Update</v-btn>

          <v-btn type="submit" :disabled="disabled" color="teal" v-else>Create</v-btn>
        </v-card-actions>
         </v-form>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  export default {
 data(){
        return{
            dialog:false,
            form:{
                name:null
            },
            teams:{},
            roles:{},
            editSlugt:null,
            errors:null
        }
    },
        created(){
            if(!User.admin()){
                this.$router.push('/forum')
            }
        axios.get('/api/role')
            .then(res => this.roles = res.data.data)

  axios.get('/api/count-team')
            .then( res => {this.teams = res.data ;console.log(res.data); } )




    },

    methods:{
        submit(){
            this.editSlugt  ?  this.update() : this.create()
        },
        update(){
            axios.post(`/api/role/${this.editSlugt}`,this.form)
            .then(res =>{
                    this.roles.unshift(res.data)
                    this.form.name = null
                })
        },
        create(){
            axios.post('/api/role',this.form)
                .then(res =>{
                    this.roles.unshift(res.data)
                    this.form.name = null
                })
                .catch(error => this.errors = error.response.data.errors)
        },
        destroy(slug, index){
            axios.delete(`/api/role/${slug}`)
                .then(res => this.roles.splice(index,1))
        },
        edit(index){

            this.form.name = this.roles[index].name
            this.editSlugt = this.roles[index].slug
            this.roles.splice(index,1)

        }
    },
    computed:{
        disabled(){
            return !(this.form.name)
        }
    }

}
</script>

<style>

</style>
