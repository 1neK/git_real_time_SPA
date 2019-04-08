<template>

    <v-layout row>

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
        <br>


        <v-dialog v-model="dialog" persistent max-width="600px">
            <template v-slot:activator="{ on }">
                <v-btn color="primary" dark v-on="on">Open Dialog</v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <span class="headline">User Profile</span>
                </v-card-title>
                <v-card-text>

                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="dialog = false">Close</v-btn>
                    <v-btn color="blue darken-1" flat @click="dialog = false">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>

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


                team: {},dialog: false
            }


        },
        created() {
            console.dir(this.$route.params.id)

            axios.get('/api/team/' + this.$route.params.id)
                .then(res => this.team = res.data)
        },

        methods: {},
        computed: {}
    }
</script>

<style>

</style>
