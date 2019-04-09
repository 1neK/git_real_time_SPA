<template>
<div>
    <div>
        <v-container fluid grid-list-md >
        <v-layout row wrap>
                <v-flex xs3 md1>
                    <h2>Task</h2>
                </v-flex>

                         <v-flex xs2>
                            <v-card-text class="px-0">Project</v-card-text>
                            <v-select
                            :items="projects"
                            item-text="name"
                            item-value="id"
                            label="Standard"
                            ></v-select>

                            <v-card-text class="px-0">Start Date</v-card-text>
                             <v-menu
                                     ref="menu"
                                     v-model="menu"
                                     :close-on-content-click="false"
                                     :nudge-right="40"
                                     :return-value.sync="date"
                                     lazy
                                     transition="scale-transition"
                                     offset-y
                                     full-width
                                     min-width="290px"
                             >
                                 <template v-slot:activator="{ on }">
                                     <v-text-field
                                             v-model="date"
                                             label="Picker in menu"
                                             prepend-icon="event"
                                             readonly
                                             v-on="on"
                                     ></v-text-field>
                                 </template>
                                 <v-date-picker v-model="date" no-title scrollable>
                                     <v-spacer></v-spacer>
                                     <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                                     <v-btn flat color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                                 </v-date-picker>
                             </v-menu>

                            <v-card-text class="px-0">Due Date</v-card-text>
                             <v-menu
                                     ref="menu"
                                     v-model="menu"
                                     :close-on-content-click="false"
                                     :nudge-right="40"
                                     :return-value.sync="date"
                                     lazy
                                     transition="scale-transition"
                                     offset-y
                                     full-width
                                     min-width="290px"
                             >
                                 <template v-slot:activator="{ on }">
                                     <v-text-field
                                             v-model="date"
                                             label="Picker in menu"
                                             prepend-icon="event"
                                             readonly
                                             v-on="on"
                                     ></v-text-field>
                                 </template>
                                 <v-date-picker v-model="date" no-title scrollable>
                                     <v-spacer></v-spacer>
                                     <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                                     <v-btn flat color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                                 </v-date-picker>
                             </v-menu>
                        </v-flex>

                        <v-flex xs2>
                            <v-card-text class="px-0">Task Type</v-card-text>
                            <v-select
                            :items="items"
                            label="Standard"
                            ></v-select>

                            <v-card-text class="px-0">Affected To</v-card-text>
                            <v-select
                            :items="users"
                            label="Standard"
                            item-text="name"
                            item-value="id"
                            ></v-select>

                            <v-card-text class="px-0">Link</v-card-text>
                            <v-select
                            :items="items"
                            label="Standard"
                            ></v-select>
                        </v-flex>

                        <v-flex xs6>
                            <v-card-text class="px-0">Description</v-card-text>
                            <v-textarea
                            outline
                            name="input-7-4"
                            label="Outline textarea"
                            ></v-textarea>

                            <v-btn dark>Add</v-btn>
                        </v-flex>


        </v-layout>
    </v-container>

</div>

<div>
    <v-data-table colmd12  :headers="headers" :items="tasks" class="elevation-1">
        <template v-slot:items="props">
            <td>{{ props.item.id }}</td>
            <td class="text-center">{{ props.item.type }}</td>
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
</div>
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




                dialog: false,
                form: {
                    name: null
                },
                tasks: [],
                users: [],
                projects: [],
                editSlugt: null,
                errors: null
            }
        },
        created() {
            if (!User.admin()) {
                this.$router.push('/forum')
            }
            axios.get('/api/task')
                .then(res => this.tasks = res.data);


            axios.get('/api/project').then(res => this.projects = res.data.data);
            axios.get('/api/user').then(res => this.users = res.data)
        },

        methods: {

            destroy(slug, index) {
                axios.delete(`/api/task/${slug}`)
                    .then(res => this.projects.splice(index, 1))
            },
            edit(index) {

                this.form.name = this.tasks[index].name
                this.editSlugt = this.tasks[index].slug
                this.tasks.splice(index, 1)

            }
        },
        computed: {
            disabled() {
                return !(this.form.name)
            }
        }

    }
</script>

<style>

</style>
