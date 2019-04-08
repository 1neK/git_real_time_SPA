<template>

<div class="">

    <v-data-table colmd12  :headers="headers" :items="tasks" class="elevation-1">
        <template v-slot:items="props">
            <td>{{ props.item.id }}</td>
            <td class="text-center">{{ props.item.type }}</td>
            <td class="text-center">{{ props.item.email }}</td>
            <td class="text-center">
                <span class="text-danger">activated
                </span>


            </td>
            <td class="text-center">
                <v-icon large danger>delete_forever</v-icon>
            </td>

        </template>
    </v-data-table>

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
            headers: [
                {
                    text: 'id',
                    sortable: false,
                    value: 'name'
                },
                {text: 'type', value: 'type'},
                {text: 'Affected to', value: 'user'},
                {text: 'Due Date ', value: 'status'},
                {text: 'action ', value: 'action'},

            ],

            dialog:false,
            form:{
                name:null
            },
            tasks:[],
            projects:{},
            editSlugt:null,
            errors:null
        }
    },
        created(){
            if(!User.admin()){
                this.$router.push('/forum')
            }
            axios.get('/api/task')
                .then(res => this.tasks = res.data)
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
