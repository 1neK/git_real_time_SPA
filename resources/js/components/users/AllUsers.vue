<template>
  <v-data-table
    :headers="headers"
    :items="desserts"
    class="elevation-1"
  >
    <template v-slot:items="props">
      <td>{{ props.item.id }}</td>
      <td class="text-xs-right">{{ props.item.photos }}</td>
      <td class="text-xs-right">{{ props.item.name }}</td>
      <td class="text-xs-right">{{ props.item.email }}</td>
      <td class="text-xs-right">{{ props.item.protein }}</td>
      <td class="text-xs-right">{{ props.item.role }}</td>
      <td class="text-xs-right">{{ props.item.active }}</td>
      <td class="text-xs-right">{{ props.item.created }}</td>
      <td class="text-xs-right">{{ props.item.updated }}</td>
    </template>
  </v-data-table>
</template>
<script>
  export default {
    data () {
      return {
        headers: [
          {
            text: 'ID',
            align: 'left',
            sortable: false,
            value: 'id'
          },
          { text: 'Photos', value: 'photos' },
          { text: 'Name', value: 'name' },
          { text: 'Email', value: 'email' },
          { text: 'Role', value: 'role' },
          { text: 'Active', value: 'active' },
          { text: 'Created', value: 'created' },
          { text: 'Updated', value: 'updated' },
        ],
        desserts: [
          {
            
          },
        ]
      }
    }
  }
</script>
