<template>
    <v-navigation-drawer permanent>

    <v-list dense class="pt-0">
      <v-list-tile
        v-for="item in items"
        :key="item.title"
        @click=""
      >
        <v-list-tile-action>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>{{ item.title }}</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
export default {
     data () {
      return {
        items: [
          { title: 'Teams', icon: 'group' },
          { title: 'Projects', icon: 'ballot' },
          { title: 'Tasks', icon: 'storage' },
          { title: 'Users', icon: 'list' },
          { title: 'Dashboard', icon: 'dashboard' },
          //{ title: 'About', icon: 'question_answer' }
        ],
        right: null
      }
    }
}
</script>

<style>

</style>
