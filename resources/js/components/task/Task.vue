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

            <v-flex> <v-card-text class="px-0">Project</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Task</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Affected To</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Start Date</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Due Date</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Completed on</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Comments</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Status</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Links</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Action</v-card-text> </v-flex>

            <v-flex xs10 v-for="project in projects" :key="project.id">
                <v-card>
                    <div v-for="task in project.task_list" :key="task.id">
                        <v-flex>
                            {{ project.name }}
                            {{ task.name }}
                            {{ user.name }}
                            {{ task.start_date }}
                            {{ task.due_date }}
                            {{ task.completed_on }}
                            {{ question.body }}
                            {{ task.status }}
                            {{ task.link }}
                            <v-btn icon small  @click="destroy(task.slug,index)">
                                <v-icon color="red">delete</v-icon>
                            </v-btn>
                            <v-btn icon small @click="edit(index)">
                                <v-icon color="orange">edit</v-icon>
                            </v-btn>
                        </v-flex>
                        <v-flex xs2></v-flex>
                    </div>

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
          <v-icon x-large>view_list</v-icon>
        </v-card-title>

        <v-card-text>

            <v-alert v-if="errors" type="error" :value="true" >
                Task name is required.
            </v-alert>


        <v-text-field
            label="Task name"
             v-model="form.name"
            type="text"
            required
        ></v-text-field>


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
            tasks:{},
            projects:{},
            editSlugt:null,
            errors:null
        }
    },
        created(){
            if(!User.admin()){
                this.$router.push('/forum')
            }
            axios.get('/api/liste-task')
                .then(res => this.tasks = res.data.data)
},

    methods:{

        destroy(slug, index){
            axios.delete(`/api/task/${slug}`)
                .then(res => this.projects.splice(index,1))
        },
        edit(index){

            this.form.name = this.tasks[index].name
            this.editSlugt = this.tasks[index].slug
            this.tasks.splice(index,1)

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
