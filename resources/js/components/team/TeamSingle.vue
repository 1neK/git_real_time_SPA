<template>

    <v-data-table :headers="headers" :items="team.users" class="elevation-1">
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


                team: {}
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
