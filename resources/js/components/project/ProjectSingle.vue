<template>
<div>
<h1 class="text-center">{{project.name}}</h1>

        <v-data-table colmd12  :headers="headers" :items="project.tasks" class="elevation-1">
            <template v-slot:items="props">
                <td>{{ props.item.id }}</td>
                <td class="text-center">{{ props.item.type }}</td>
                <td class="text-center">{{ props.item.user }}</td>
                <td class="text-center">{{ props.item.start_date }}</td>
                <td class="text-center">
                <span class="text-danger">activated
                </span>
                </td>
                <td class="text-center">
                    <v-icon large danger>edit</v-icon>
                    <v-icon large danger>delete_forever</v-icon>
                </td>


            </template>
        </v-data-table>

    </div>


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
                    {text: 'type', value: 'type'},
                    {text: 'Affected to', value: 'user'},
                    {text: 'Due Date ', value: 'status'},
                    {text: 'action ', value: 'action'},

                ],


                project: {},dialog: false
            }


        },
        created() {


            axios.get('/api/project/' + this.$route.params.id)
                .then(res => this.project = res.data)
        },

        methods: {},
        computed: {}
    }
</script>

<style>

</style>
