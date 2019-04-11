<template>
    <div class="">

        <v-data-table colmd12  :headers="headers" :items="teams" class="elevation-1">
            <template v-slot:items="props">
                <td>{{ props.item.id }}</td>
                <td class="text-center">{{ props.item.name }}</td>
                <td class="text-center">{{ props.item.email }}</td>
                <td class="text-center">
                <span class="text-danger">
                </span>

                    <v-chip color="green" v-if="props.item.is_active" text-color="white">activated</v-chip>

                    <v-chip color="blue" v-else text-color="white">Pending</v-chip>
                </span>

                </td>
                <td class="text-center">{{ props.item.roles }}</td>
                <td class="text-center">
                    <v-btn icon><v-icon large danger>edit</v-icon></v-btn>
                    <v-btn icon><v-icon large danger>delete_forever</v-icon></v-btn>
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
          <v-icon x-large>supervised_user_circle</v-icon>
        </v-card-title>

        <v-card-text>

            <v-alert v-if="errors" type="error" :value="true" >
                User name is required.
            </v-alert>


        <v-text-field
            label="name"
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
                {text: 'name', value: 'name'},
                {text: 'email', value: 'email'},
                {text: 'status ', value: 'status'},
                {text: 'role ', value: 'role'},

                {text: 'action ', value: 'action'},

            ],


            teams:[],
            dialog:false,
            form:{
                name:null,
            },
            editSlugt:null,
            errors:null
        }
    },
     created(){

        axios.get('/api/user')
            .then(res => this.teams = res.data)
    },
    methods:{
        destroy(slug, index){
            axios.delete(`/api/user/${slug}`)
                .then(res => this.roles.splice(index,1))
        },
        edit(index){

            this.form.name = this.users[index].name
            this.editSlugt = this.users[index].slug
            this.users.splice(index,1)

        }
    },

}
</script>

<style>

</style>
