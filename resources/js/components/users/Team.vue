<template>

    <v-container>

        <h3 class="title font-weight-bold">Teams</h3>
        <v-flex xs12></v-flex>
        <v-flex xs12></v-flex>

        <v-dialog v-model="dialog" width="500">

            <template v-slot:activator="{ on }">

                <v-layout row wrap>

                    <v-flex xs12 sm12 md6 v-for="team in teams" :key="team.id">

                        <v-card class="carteam">
                            <v-toolbar color="white" flat>
                                <v-flex xs7>

                                        <a><router-link :to="{ name: 'team-single', params: { id:  team.slug } }"  >  <h3 class="title font-weight-bold">{{ team.name }}</h3></router-link></a>

                                </v-flex>

                                <v-flex xs2>
                                    <v-card-actions>
                                        <v-tooltip bottom>
                                          <template v-slot:activator="{ on }">
                                                <v-btn icon v-if="team.id !=1 && team.id !=2" v-on="on">
                                                    <v-icon  medium color="#A4AFB7" @click="editpopup(team)"> create</v-icon>
                                                </v-btn>
                                          </template>
                                          <span>edit</span>
                                        </v-tooltip>
                                        <v-tooltip bottom>
                                          <template v-slot:activator="{ on }">
                                                <v-btn icon  v-if="team.id !=1 && team.id !=2" @click="destroy( team.id )" v-on="on">
                                                    <v-icon medium color="#A4AFB7"> remove_circle</v-icon>
                                                </v-btn>
                                          </template>
                                          <span>remove</span>
                                        </v-tooltip>
                                    </v-card-actions>
                                </v-flex>
                            </v-toolbar>
                            <v-card-title primary-title >
                                <div class="font-weight-regular">

                                    <div> Tasks : {{ team.task_number }}</div>
                                    <div> Total users : {{ team.user_number }}</div>
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
                            icon
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
                        <v-icon x-large color="black">supervised_user_circle</v-icon>
                    </v-card-title>

                    <v-card-text>

                        <v-alert v-if="errors" type="error" :value="true">
                            Team name is required.
                        </v-alert>


                     <v-text-field
                                placeholder="Team Name"
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
                teams: {},
                roles: {},
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
.container {
  max-width: 960px;
}
.carteam{
    border-radius: 8px;
}
a:link{
    color:#4D4F5C;
    text-decoration: none;
}

a:visited{
    color:#4D4F5C;
    text-decoration: none;
}

</style>
