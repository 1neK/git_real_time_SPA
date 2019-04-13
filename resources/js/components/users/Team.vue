<template>

    <div class="sm8">

        <v-dialog v-model="dialog" width="500">

            <template v-slot:activator="{ on }">

                <v-layout row wrap>

                    <v-flex sm4 v-for="team in teams" :key="team.id">

                        <v-card>
                            <v-card-title primary-title >
                                <div>
                                 <router-link :to="{ name: 'team-single', params: { id:  team.slug } }"  >  <h3 class="headline mb-0">{{ team.name }}</h3></router-link>
                                    <div> task : {{ team.task_number }}</div>
                                    <div> users : {{ team.user_number }}</div>
                                </div>
                            </v-card-title>
                            <v-toolbar color="white" flat>
                            <v-spacer></v-spacer>
                            <v-card-actions>
                                <v-btn icon>
                                    <v-icon medium color="green" @click="editpopup(team)"> edit</v-icon>
                                </v-btn>
                                <v-btn icon @click="destroy( team.id )">
                                    <v-icon medium color="red"> delete</v-icon>
                                </v-btn>
                            </v-card-actions>
                            </v-toolbar>
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
                        <v-icon x-large>supervised_user_circle</v-icon>
                    </v-card-title>

                    <v-card-text>

                        <v-alert v-if="errors" type="error" :value="true">
                            Team name is required.
                        </v-alert>


                        <v-text-field
                                label="Team Name"
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
                        <v-btn type="submit" :disabled="disabled" color="cyan" v-if="editSlugt">Update</v-btn>

                        <v-btn type="submit" :disabled="disabled" color="teal" v-else>{{form.btn_name}}</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
    </div>
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
                teams: {},
                roles: {},
                editSlugt: null,
                errors: null
            }

        },
        created() {

            axios.get('/api/role')
                .then(res => this.roles = res.data.data);

            this.getData();


        },

        methods: {
            submit() {
                this.form.id ? this.update() : this.create()
            },
            update() {
                axios.put(`/api/team/${this.form.id}`, this.form)
                    .then(res => {

                        this.form.name = null
                        this.dialog = false;
                        this.getData();

                    })
            },
            create() {
                axios.post('/api/team?token=' + localStorage.getItem('token'), this.form)
                    .then(res => {

                        this.form.name = null
                        this.dialog = false;
                        this.getData();
                    })
                    .catch(error => this.errors = error.response.data.errors)
            },
            destroy(slug) {
                axios.delete(`/api/team/${slug}`)
                    .then(res => this.getData())
            },


            editpopup(team) {
                this.form.name = team.name;
                this.form.id = team.id;
                this.form.btn_name = 'update';
                this.dialog = true

            },

            reset() {

                this.form.name = null;
                this.form.id = null;
                this.form.btn_name = 'created';

            },

            getData() {

                axios.get('/api/count-team')
                    .then(res => {
                        this.teams = res.data;
                        console.log(res.data);
                    });

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

</style>
