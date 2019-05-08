<template>
    <v-layout row wrap>
        <v-container>
            <h3 class="title font-weight-bold">Task</h3>
            <v-flex xs12></v-flex>
            <v-flex xs12></v-flex>
            <v-flex xs12>
                <v-card>
                    <v-container>

                        <v-card-text class=" font-weight-bold">
                            <v-toolbar flat color="white">
                                <v-spacer></v-spacer>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on">
                                            <v-icon medium color="orange" @click="edittask()">edit</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>edit</span>
                                </v-tooltip>
                            </v-toolbar>
                            <v-flex md12>
                                <v-subheader>
                                    <h3>Affected To:
                                        <small v-if="!mark">{{task.user}}</small>
                                        <v-select v-else
                                                :items="users"
                                                placeholder="Affected To"
                                                v-model="form.user_id"
                                                item-text="name"
                                                item-value="id"
                                        ></v-select>
                                    </h3>
                                </v-subheader>
                            </v-flex>
                        </v-card-text>
                        <v-flex md12>
                            <v-card-text class=" font-weight-bold">
                                <v-subheader>
                                    <h3>Start Date:
                                        <small v-if="!mark">{{task.start_date}}</small>
                                        <v-menu v-else
                                                v-model="menu1"
                                                :close-on-content-click="false"
                                                :nudge-right="40"
                                                lazy
                                                transition="scale-transition"
                                                offset-y
                                                full-width
                                                min-width="290px"
                                        >
                                            <template v-slot:activator="{ on }">
                                                <v-text-field
                                                        v-model="form.start_date"
                                                        prepend-icon="event"
                                                        readonly
                                                        v-on="on"
                                                ></v-text-field>
                                            </template>
                                            <v-date-picker v-model="form.start_date" @input="menu1 = false"></v-date-picker>
                                        </v-menu>
                                    </h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <h3>Due Date:
                                        <small v-if="!mark">{{task.due_date}}</small>
                                        <v-menu v-else
                                                v-model="menu"
                                                :close-on-content-click="false"
                                                :nudge-right="40"
                                                lazy
                                                transition="scale-transition"
                                                offset-y
                                                full-width
                                                min-width="290px"
                                        >
                                            <template v-slot:activator="{ on }">
                                                <v-text-field
                                                        v-model="form.due_date"
                                                        prepend-icon="event"
                                                        readonly
                                                        v-on="on"
                                                ></v-text-field>
                                            </template>
                                            <v-date-picker v-model="form.due_date" @input="menu = false"></v-date-picker>
                                        </v-menu>

                                    </h3>
                                </v-subheader>
                            </v-card-text>
                        </v-flex>

                        <v-card-text class=" font-weight-bold">
                            <v-flex md12>
                                <v-subheader>
                                    <h3>Status:
                                        <small>{{task.status}}</small>
                                    </h3>
                                </v-subheader>
                            </v-flex>
                        </v-card-text>




                        <v-card-text class=" font-weight-bold">
                            <v-flex md12  class="py-5">
                                <v-subheader>
                                    <h3>Description:
                                        <small  v-if="!mark"><p > {{task.description}}</p></small>

                                        <v-textarea v-else
                                                outline
                                                v-model="form.description"
                                                name="input-7-4"

                                        ></v-textarea>
                                    </h3>
                                </v-subheader>
                            </v-flex>
                        </v-card-text>

                    </v-container>


<v-btn v-if="mark" @click="update()">save</v-btn>
                    <v-btn v-if="mark" @click="mark=false">cancel</v-btn>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <div class=" font-weight-bold">
                            <h5>Added By: <p> {{task.createdBy}} </p></h5>
                        </div>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-container>
        <v-container>
            <h3 class="font-weight-bold">Comments: </h3>
            <v-flex xs12></v-flex>
            <v-flex xs12></v-flex>
            <div class="mt-3" v-for="(data ,index) in task.task_comment">
                <v-card>
                    <v-card-title>
                        <div class="headline">{{data.user}}</div> &nbsp;&nbsp;&nbsp;
                        <div class="ml-2">said {{data.created_at}}</div>
                        <v-spacer></v-spacer>
                    </v-card-title>

                    <v-divider></v-divider>


                    <div  v-if="editing[index]" >
                        <div>
                            <markdown-editor ref="markdown"v-model="editForm.body"></markdown-editor>
                            <v-card-actions>
                                <v-btn icon small @click="updatecomment(index)">
                                    <v-icon color="#5FD179">save</v-icon>
                                </v-btn>
                                <v-btn icon small @click="editing[index] = false">
                                    <v-icon color="#F5181F">cancel</v-icon>
                                </v-btn>
                            </v-card-actions>
                        </div>

                    </div>


                    <v-card-text v-else v-html="data.body"></v-card-text>

                    <v-divider></v-divider>
                    <div v-if="!editing[index]">
                        <v-card-actions v-if="own">
                            <v-spacer></v-spacer>
                            <v-btn icon small @click="edit(index)">
                                <v-icon color="orange">edit</v-icon>
                            </v-btn>
                            <v-btn icon small @click="destroy(data.id)">
                                <v-icon color="#F5181F">delete_forever</v-icon>
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
                        color="#3B86FF"
                        class="btn2"
                        type="submit"
                        :disabled="disabled"
                >SEND
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
                editForm:[],
                users :[],
                task: {},
                mark:false,
                errors: {}
            }
        },


        created() {
            this.init();


        },
        methods: {
            create() {
                axios.post('/api/task/comment/' + this.$route.params.id , this.form)
                    .then(res => {
                        this.init();
                        this.form.body = '';


                    })
                    .catch(error => this.errors = error.response.data.errors)
            }
            ,

            update(){
                axios.put(`/api/task/${this.form.id}`,this.form)
                    .then(res =>{

                        this.init();
                        this.mark=false;
                    })
            },

            init() {

                axios.get('/api/task/' + this.$route.params.id)
                    .then(res => {
                        this.task = res.data;})

                axios.get('/api/user').then(res => this.users = res.data)


            }
            ,
            edit(index) {

                this.editing[index] = true;
                this.editForm = Object.assign({},this.task.task_comment[index]);
                this.init();

            },


            edittask(){

                this.mark=true;


                this.form = Object.assign({},this.task);



            },

            own() {
                return User.own(this.data.user_id)
            },

            destroy(index) {


                axios.delete('/api/task/comment/' + index, this.form)
                    .then(res => this.init())
                    .catch(error => this.errors = error.response.data.errors)
            },

            cancel(index) {
                this.editing[index] = false;
            },
            updatecomment(index) {
                axios.patch('/api/task/comment/'+this.editForm.id, this.editForm)
                    .then(res =>  {this.cancel(index) ;this.init()})
            }

        },
        computed: {
            disabled() {
                return !(this.form.body)
            },


        },




    }
</script>

<style>
    .container {
        max-width: 960px;

    }

    .btn2 {
        border: none;
        color: white;
        padding: 7px 40px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        font-size: 12px;
        border-radius: 2px;
        left: 50%;
    }

</style>
