<template>
<div>
<v-container fluid grid-list-md >
    <v-layout row wrap>
            <v-flex xs3 md2>
                <h2>Users</h2>
            </v-flex>
            <v-flex xs3 md10> </v-flex>
            <v-flex xs2></v-flex>

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
</v-container>
</div>
</template>

<script>
export default {
 data(){
        return{
            team:{},
            teams:{}
        }
    },
     created(){
        axios.get('/api/liste-team')
            .then(res => this.teams = res.data)
    },
    methods:{
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

}
</script>

<style>

</style>
