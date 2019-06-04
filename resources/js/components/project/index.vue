<template>

    <v-container>
        <h3 class="title font-weight-bold">Projects</h3>
        <v-flex xs12></v-flex>
        <v-flex xs12></v-flex>
        <v-dialog v-model="dialog" width="500">

            <template v-slot:activator="{ on }">

                <v-layout row wrap>

                    <v-flex xs12 sm12 md6 v-for="project in projects" :key="project.id">
                        <v-card class="carteam1">

                            <v-toolbar color="white" flat>

                                <v-flex md9 xs6>
                                    <router-link :to="{ name: 'project-single', params: { id:  project.slug } }"><h3
                                            class="title font-weight-bold">{{ project.name }}</h3></router-link>
                                </v-flex>

                                <v-flex md4 xs6>
                                    <v-card-actions>
                                        <v-tooltip bottom>
                                            <template v-slot:activator="{ on }">
                                                <v-btn icon v-on="on" class="btp">
                                                    <v-icon medium color="#A4AFB7" @click="editpopup(project)"> edit
                                                    </v-icon>
                                                </v-btn>
                                            </template>
                                            <span>edit</span>
                                        </v-tooltip>
                                        <v-tooltip bottom>
                                            <template v-slot:activator="{ on }">
                                                <v-btn icon @click="destroy( project.id )" v-on="on" class="btp">
                                                    <v-icon medium color="#A4AFB7">remove_circle</v-icon>
                                                </v-btn>
                                            </template>
                                            <span>remove</span>
                                        </v-tooltip>
                                    </v-card-actions>
                                </v-flex>

                            </v-toolbar>

                            <v-card-title>
                                <div>

                                    <div> Tasks : {{ project.task_number }}</div>
                                    <div> Tasks in progress : {{project.progress_task}}</div>
                                    <div> Pending Tasks : {{project.pending_task}}</div>
                                    <div> Completed Tasks : {{project.completed_task}}</div>
                                    <v-divider></v-divider>
                                </div>

                            </v-card-title>


                        </v-card>
                    </v-flex>
                </v-layout>

                <v-card-text class="text-right" style="height: 100px; position: relative">

                    <v-btn
                            v-on="on"
                            @click="reset()"
                            absolute
                            dark
                            fab
                            bottom
                            right
                            color="pink"

                    >
                        <v-icon>add</v-icon>
                    </v-btn>
                </v-card-text>

            </template>

            <v-card>
                <v-form @submit.prevent="submit">
                    <v-card-title
                            class="headline grey lighten-2"
                            primary-title
                    >
                        <v-icon x-large color="black">work</v-icon>
                    </v-card-title>

                    <v-card-text>

                        <v-alert v-if="errors" type="error" :value="true">
                            Project name is required.
                        </v-alert>


                        <v-text-field
                                placeholder="Project Name"
                                autofocus
                                v-model="form.name"
                                required></v-text-field>


                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                                color="primary"
                                flat
                                @click="dialog = false"
                        >
                            close
                        </v-btn>
                        <v-btn type="submit" :disabled="disabled" color="#43425D" v-if="editSlugt">Update</v-btn>

                        <v-btn type="submit" :disabled="disabled" color="#43425D" v-else>{{form.btn_name}}</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                dialog: false,
                form: {
                    id: null,
                    name: null,
                    btn_name: 'create'
                },
                projects: {},
                //roles:{},
                editSlugt: null,
                errors: null
            }
        },
        created() {
            this.getData();
        },

        methods: {
            submit() {
                this.form.id ? this.update() : this.create()
            },
            update() {
                axios.put(`/api/project/${this.form.id}`, this.form)
                    .then(res => {
                            this.dialog = false;
                            this.getData();
                        this.$swal('Success', res.data, 'success');
                    }).catch(error => this.$swal('Error', error.response.data.error, 'error'));
            },
            create() {
                axios.post('/api/project?token=' + localStorage.getItem('token'), this.form)
                    .then(res => {

                        this.form.name = '';
                        this.dialog = false;
                        this.getData();

                        this.$swal('Success', res.data, 'success');
                    }).catch(error => this.$swal('Error', error.response.data.error, 'error'));
            },
            destroy(slug) {
                axios.delete(`/api/project/${slug}`)
                    .then(res => {this.getData();

                        this.$swal('Success', res.data, 'success');
                    }).catch(error => this.$swal('Error', error.response.data.error, 'error'));
            },
            edit(index) {

                this.form.name = this.projects[index].name
                this.editSlugt = this.projects[index].slug
                this.projects.splice(index, 1)

            },
            editpopup(project) {
                this.form.name = project.name;
                this.form.id = project.id;
                this.form.btn_name = 'update';
                this.dialog = true

            },

            reset() {

                this.form.name = null;
                this.form.id = null;
                this.form.btn_name = 'create';

            },
            getData() {
                axios.get('/api/project').then(res => this.projects = res.data);
                this.reset();

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
    .container {
        max-width: 960px;
    }

    .btp {
        left: 0px;
    }

    .carteam1 {
        border-radius: 12px;
    }
</style>
