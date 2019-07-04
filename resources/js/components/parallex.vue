<template>
<v-flex flex sm9 xs9>
  <v-parallax
    height="700"
    src="https://cdn.vuetifyjs.com/images/parallax/material2.jpg" v-if="user.loggedIn()">
    <v-layout
        align-center
        column
        justify-center >
      <h1 class="display-4 font-weight-thin mb-3">RTM</h1>
      <h4 class="headline">Real Time Monitoring</h4>
    </v-layout>
    </v-parallax>
</v-flex>
</template>

<script>
  import User from '../Helpers/User';
export default {
  data() {
    return {
      user:User
    }
  },
  created() {

  },

}
</script>

<style>

</style>
