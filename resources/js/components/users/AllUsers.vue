<template>
    <div class="">

        <v-data-table colmd12  :headers="headers" :items="team.users" class="elevation-1">
            <template v-slot:items="props">
                <td>{{ props.item.id }}</td>
                <td class="text-center">{{ props.item.name }}</td>
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

            <v-flex> <v-card-text class="px-0">ID</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Name</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Email</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Created_at</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Last Connection</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Role</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Status</v-card-text> </v-flex>
            <v-flex> <v-card-text class="px-0">Action</v-card-text> </v-flex>

            <v-flex xs10 v-for="team in teams" :key="team.id">
                <v-card to="/liste_team">
                    <div v-for="user in team.user_list" :key="user.id">
                        <v-flex>
                            {{ user.id }}
                            {{ user.name }}
                            {{ user.email }}
                            {{ user.last_login_at }}
                            {{ user.email }}
                            {{ team.name }}
                            {{ user.is_active }}
                            <v-btn icon small  @click="destroy(team.slug,index)">
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
            team:{},
            teams:{},
            dialog:false,
            form:{
                name:null,
            },
            editSlugt:null,
            errors:null
        }
    },
     created(){
         if(!User.admin()){
                this.$router.push('/forum')
            }
        axios.get('/api/liste-team')
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
