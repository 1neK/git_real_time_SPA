<template>
    <v-layout row wrap>
          <v-flex xs9 v-for="user in team.list_users" :key="user.id">

            <v-card to="/liste_team">
              <v-card-title primary-title>
                <div>
                  <h3 class="headline mb-0">{{ user.name }}</h3>
                  <div> {{ team.user_list }} </div>
                </div>
              </v-card-title>
            <v-card-actions>
                <v-icon flat color="grey">edit</v-icon>
                <v-icon flat color="grey">delete</v-icon>
             </v-card-actions>
           </v-card>
          </v-flex>
  </v-layout>
</template>

<script>
export default {

}
</script>

<style>

</style>
