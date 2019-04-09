<template>

<div class="">

    <v-dialog  v-model="dialog"  width="500"  >

      <template v-slot:activator="{ on }">

          <v-layout row wrap>

              <v-flex xs9 sm4 v-for="project in projects" :key="project.id">
                  <v-card >

                      <v-card-title :to="{ name: 'project-single', params: { id:  project.slug } }">
                          <div>
                              <h3 class="headline mb-0">{{ project.name }}</h3>
                              <div> task : {{ project.task_number }}</div>
                          </div>
                      </v-card-title>
                      <v-toolbar color="white" flat>
                          <v-spacer></v-spacer>
                          <v-card-actions>
                              <v-btn flat>
                                  <v-icon color="grey darken-4" @click="editpopup(project)"> edit</v-icon>
                              </v-btn>
                              <v-btn flat @click="destroy( project.id )">
                                  <v-icon color="red"> delete</v-icon>
                              </v-btn>
                          </v-card-actions>
                      </v-toolbar>

                  </v-card>
              </v-flex>
          </v-layout>

          <v-card-text class="text-right" style="height: 100px; position: relative">

            <v-btn
             v-on="on"
              absolute
              dark
              fab
              bottom
              right
              color="pink"

            >
              <v-icon>add</v-icon>
            </v-btn>
          </v-card-text>

      </template>

      <v-card>
            <v-form @submit.prevent="submit">
        <v-card-title
          class="headline grey lighten-2"
          primary-title
        >
          <v-icon x-large>work</v-icon>
        </v-card-title>

        <v-card-text>

            <v-alert v-if="errors" type="error" :value="true" >
                Project name is required.
            </v-alert>



            <v-text-field
            label="Project Name"
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

          <v-btn type="submit" :disabled="disabled" color="teal" v-else>{{form.btn_name}}</v-btn>
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
            form: {
                id: null,
                name: null,
                btn_name: 'create'
            },
            projects:{},
            //roles:{},
            editSlugt:null,
            errors:null
        }
    },
        created(){
            if(!User.admin()){
                this.$router.push('/forum')
            }

          this.getData();


            axios.get('/api/count-task')
                .then( res => {this.projects = res.data ;console.log(res.data); } )
},

    methods:{
        submit(){
            this.form.id  ?  this.update() : this.create()
        },
        update(){
            axios.put(`/api/project/${this.form.id}`,this.form)
            .then(res =>{

                this.dialog = false;
                this.getData();
                })
        },
        create(){
            axios.post('/api/project?token='+localStorage.getItem('token'),this.form)
                .then(res =>{

                    this.form.name='';
                    this.dialog=false;
                    this.getData();

                })
                .catch(error => this.errors = error.response.data.errors)
        },
        destroy(slug){
            axios.delete(`/api/project/${slug}`)
                .then(res =>   this.getData())
        },
        edit(index){

            this.form.name = this.projects[index].name
            this.editSlugt = this.projects[index].slug
            this.projects.splice(index,1)

        },
        editpopup(project) {
            this.form.name = project.name;
            this.form.id = project.id;
            this.form.btn_name = 'update';
            this.dialog = true

        },

        reset() {

            this.form.name = null;
            this.form.id = null;
            this.form.btn_name = 'created';

        },
        getData(){
            axios.get('/api/project').then(res => this.projects = res.data.data);
            this.reset();

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
