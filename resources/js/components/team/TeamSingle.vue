<template>
<v-container>
        <!--<v-flex v-for="team in teams" :key="team.id">
            <h3 class="title font-weight-bold" >{{team.name}}</h3>
        </v-flex>-->

        <v-flex xs12></v-flex>
        <v-flex xs12></v-flex>

    <v-data-table colmd12  :headers="headers" :items="team.users" class="elevation-1">
        <template v-slot:items="props">
            <td>{{ props.item.id }}</td>
            <td class="text-center">{{ props.item.name }}</td>
            <td class="text-center">{{ props.item.email }}</td>
            <td class="text-center">
                <v-chip color="#5FD179" text-color="white">{{ props.item.status }}</v-chip>
            </td>
            <td class="text-center">
                <v-btn icon >
                    <v-icon color="#F5181F" medium danger @click="destroy(props.item.id)">delete_forever</v-icon>
                </v-btn>
               <!-- <v-btn icon >
                    <v-icon black medium danger>edit</v-icon>
                </v-btn>-->

            </td>

        </template>
    </v-data-table>
</v-container>

</template>

<script>
    export default {
        data() {
            return {
                headers: [
                    {
                        text: 'id',
                        sortable: false,
                        value: 'name'
                    },
                    {text: 'name', value: 'name'},
                    {text: 'email', value: 'email'},
                    {text: 'status ', value: 'status'},
                    {text: 'action ', value: 'action'},

                ],

                status:['Pending','Active','Banned'],
                team: {},
                dialog: false,

            }


        },
        created() {

            this.init();


        },



        methods: {

            destroy(slug) {
                axios.delete(`/api/user/${slug}`)
                    .then(res => this.init())
            },

            init(){
                axios.get('/api/team/' + this.$route.params.id)
                    .then(res => this.team = res.data);

            }


        },
        computed: {}
    }
</script>

<style>
.buttonT{
  padding: 2px 10px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 20px;
  margin: 4px 2px;
  cursor: pointer;
  font-size: 12px;
  border-radius: 12px;
}
</style>
