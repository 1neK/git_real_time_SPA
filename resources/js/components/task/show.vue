<template>
    <v-layout row wrap>
        <v-container>
            <v-flex xs12>
                <h4>Task</h4>
            </v-flex>
            <v-flex xs12>
                <v-card>
                    <v-container>
                        <v-toolbar flat color="white">
                            <v-spacer></v-spacer>
                            <v-btn icon>
                                <v-icon medium color="orange">edit</v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-flex md6>
                            <v-subheader>
                                <v-card-text class="py-1">
                                    <h3>Affected To:
                                        <small>{{task.user}}</small>
                                    </h3>
                                </v-card-text>
                            </v-subheader>
                            <v-subheader>
                                <v-card-text class="py-1">
                                    <h3>Start Date:
                                        <small>{{task.start_date}}</small>
                                    </h3>
                                </v-card-text>
                                <v-card-text class="py-1">
                                    <h3>Due Date:
                                        <small>{{task.due_date}}</small>
                                    </h3>
                                </v-card-text>
                            </v-subheader>
                            <v-subheader>
                                <v-card-text class="py-1">
                                    <h3>Status:
                                        <small>{{task.status}}</small>
                                    </h3>
                                </v-card-text>
                            </v-subheader>
                            <v-subheader>
                                <v-card-text class="py-1"><h3>Description:</h3>

                                    <p>{{task.description}}</p>
                                </v-card-text>
                            </v-subheader>

                        </v-flex>
                    </v-container>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <h5>Added By: &nbsp;</h5>
                        <p> {{task.createdBy}} </p>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-container>
        <v-container>
            <div class="mt-3" v-for="(data ,index) in task.task_comment">
                <v-card>
                    <v-card-title>
                        <div class="headline">{{data.user}}</div>
                        <div class="ml-2">said {{data.created_at}}</div>
                        <v-spacer></v-spacer>
                    </v-card-title>

                    <v-divider></v-divider>


                    <div
                            v-if="editing[index]"
                            >

                        <div>
                            <markdown-editor v-model="data.body"></markdown-editor>
                            <v-card-actions>
                                <v-btn icon small @click="update">
                                    <v-icon color="green">save</v-icon>
                                </v-btn>
                                <v-btn icon small @click="cancel">
                                    <v-icon color="black" >cancel</v-icon>
                                </v-btn>
                            </v-card-actions>
                        </div>

                    </div>


                    <v-card-text v-else v-html="data.body"></v-card-text>

                    <v-divider></v-divider>
                    <div v-if="!editing[index]">
                        <v-card-actions v-if="own">
                            <v-btn icon small @click="edit(index)">
                                <v-icon color="orange">edit</v-icon>
                            </v-btn>
                            <v-btn icon small @click="destroy(index)">
                                <v-icon color="red">delete</v-icon>
                            </v-btn>
                        </v-card-actions>
                    </div>
                </v-card>
            </div>
        </v-container>

        <v-container>
            <v-form @submit.prevent="create">
                <span class="red--text" v-if="errors.body">{{errors.body[0]}}</span>
                <markdown-editor v-model="form.body"></markdown-editor>
                <v-btn
                        color="green"
                        type="submit"
                        :disabled="disabled"
                >Create
                </v-btn>
            </v-form>
        </v-container>

    </v-layout>
</template>

<script>
    import EditReply from './editReply';

    export default {
        components: {EditReply},
        data() {
            return {
                form: {

                    body: null

                },
                editing: [],
                task: {},
                errors: {}
            }
        },


        created() {
            this.init();



        },
        methods: {
            create() {
                axios.post('/api/task/' + this.$route.params.id + '?token=' + localStorage.getItem('token'), this.form)
                    .then(res => this.init())
                    .catch(error => this.errors = error.response.data.errors)
            }
            ,
            init() {

                axios.get('/api/task/' + this.$route.params.id)
                    .then(res => {
                        this.task = res.data;

                        for (let i = 0; i < this.task.task_comment.length; i++) {

                            this.task.task_comment[i].editing = false;

                        }


                    })


            }
            ,
            edit(index) {

                this.editing[index] = true;
            },

            own() {
                return User.own(this.data.user_id)
            },

            destroy() {
                // EventBus.$emit('deleteReply', this.index)
            },

            cancel(index){
                this.editing[index] = false;
            },
            update(){
                axios.patch(`/api/question/${this.reply.question_slug}/reply/${this.reply.id}`, {body:this.reply.reply})
                    .then(res => this.cancel())
            }

        },
        computed: {
            disabled() {
                return !(this.form.body)
            },


        }
    }
</script>

<style>
    .container {
        max-width: 960px;

    }
</style>
