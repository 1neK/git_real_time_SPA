<template>
<v-flex flex sm9 xs9>
    <v-container>
        <h3 class="title font-weight-bold">Tasks</h3>
        <v-container fluid grid-list-md>
            <v-layout row wrap>
                <v-flex md3 xs5>
                    <v-card-text class="px-0 font-weight-bold" id="pro">Project</v-card-text>
                    <v-select
                            :items="projects"
                            v-model="form.project_id"
                            item-text="name"
                            item-value="id"
                            placeholder="Project"
                    ></v-select>

                    <v-card-text class="px-0 font-weight-bold" id="pro">Start Date</v-card-text>
                    <v-menu
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

                    <v-card-text class="px-0 font-weight-bold" id="pro">Due Date</v-card-text>
                    <v-menu
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
                </v-flex>

                <v-flex md3 xs5>
                    <v-card-text class="px-0 font-weight-bold" id="pro">Task Type</v-card-text>
                    <v-select
                            :items="categories"
                            v-model="form.category_id"
                            item-text="name"
                            item-value="id"
                            placeholder="Task Type"
                    ></v-select>

                    <v-card-text  v-if="user.admin() || user.coordinator()" class=" font-weight-bold" id="pro">Affected To</v-card-text>
                    <v-select
                    v-if="user.admin() || user.coordinator()"
                            :items="users"
                            placeholder="Affected To"
                            v-model="form.user_id"
                            item-text="name"
                            item-value="id"
                    ></v-select>

                    <v-card-text class="px-0 font-weight-bold" id="pro">Link</v-card-text>
                    <v-text-field
                            v-model="form.link"
                            placeholder="Link"
                    ></v-text-field>
                </v-flex>

                <v-flex  md4 xs10>
                    <v-card-text class="px-0 font-weight-bold" id="pro">Description</v-card-text>
                    <v-textarea
                            outline
                            v-model="form.description"
                            name="input-7-4"

                    ></v-textarea>


                </v-flex>

                <v-flex md12 xs12 sm12 text-xs-center>

                    <v-btn dark @click="submit()">{{form.btn_name}}</v-btn>

                    <v-btn dark @click="reset()">reset</v-btn>

                </v-flex>


                <v-flex xs12 md11 sm8>
                    <v-expansion-panel popout>
                        <v-expansion-panel-content>
                            <template v-slot:header>
                                <div class="font-weight-bold" id="pro"><h4>Filter task</h4></div>
                            </template>
                            <v-layout row wrap p4>
                                <v-flex xs1></v-flex>
                                <v-flex md3 xs5>
                                    <v-card-text class="font-weight-regular" id="pro">Project</v-card-text>
                                    <v-select
                                            :items="projects"
                                            v-model="search.project_id"
                                            item-text="name"
                                            item-value="id"
                                            placeholder="Project"
                                            class="px-1"
                                    ></v-select>

                                    <v-card-text class="font-weight-regular" id="pro">Title</v-card-text>
                                    <v-select
                                            :items="categories"
                                            v-model="search.category_id"
                                            item-text="name"
                                            item-value="id"
                                            placeholder="Title"
                                            class="px-1"
                                    ></v-select>
                                </v-flex>

                                <v-flex md3 xs5>
                                    <v-card-text v-if="myRole=='Admin' || myRole=='Coordinator'"
                                                 class="font-weight-regular" id="pro">Affected To
                                    </v-card-text>
                                    <v-select v-if="myRole=='Admin' || myRole=='Coordinator'"
                                              :items="users"
                                              placeholder="Affected To"
                                              v-model="search.user_id"
                                              item-text="name"
                                              item-value="id"
                                              class="px-1"
                                    ></v-select>

                                    <v-card-text class="font-weight-regular" id="pro">Status</v-card-text>
                                    <v-select
                                            :items="status"
                                            placeholder="Status"
                                            v-model="search.status"
                                            class="px-1"
                                    ></v-select>
                                </v-flex>

                                <v-flex md4>

                                    <v-flex md6>

                                        <v-btn dark @click="filter()">filter</v-btn>


                                    </v-flex>
                                    <v-flex md6>

                                        <v-btn dark @click="getData()">reset</v-btn>

                                    </v-flex>

                                </v-flex>

                            </v-layout>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-flex>

                <v-flex md12 xs12 md1>

                </v-flex>


                <v-flex md11 xs12 sm10>
                    <v-data-table colmd12 :headers="headers" :items="tasks" class="elevation-1">
                        <template v-slot:items="props">
                            <td>
                                <router-link :to="{ name: 'task-single', params: { id:  props.item.id } }">{{
                                    props.item.project }}
                                </router-link>
                            </td>
                            <td class="text-center"> {{ props.item.category }}</td>
                            <td class="text-center"> {{ props.item.user }}</td>
                            <td class="text-center"> {{ props.item.createdBy }}</td>
                            <td class="text-center">{{ props.item.start_date }}</td>
                            <td class="text-center">{{ props.item.due_date }}</td>
                            <td class="text-center">{{ props.item.date_completed }}</td>
                            <td class="text-center">{{ props.item.comments }}</td>
                            <td class="text-center">{{ props.item.status }}</td>
                            <td class="text-center">

                                <a v-if="props.item.link" target="_blank" :href="  props.item.link ">
                                    <v-icon medium color="green">link</v-icon>
                                </a>
                                <a v-if="props.item.final_link" target="_blank" :href="props.item.final_link ">
                                    <v-icon medium color="blue">link</v-icon>
                                </a>


                            </td>
                            <td class="justify-center layout px-0" v-if="myRole=='Admin' || myRole=='Coordinator'">

                                <v-icon small class="mr-2" color="orange" @click="edit(props.item)">edit</v-icon>

                                <v-icon small color="#F5181F" @click="destroy( props.item.id )"> delete_forever</v-icon>

                                <v-btn v-if="props.item.status =='Completed'" @click="accept(props.item.id)"
                                       color="blue">accept
                                </v-btn>
                                <v-btn v-if="props.item.status =='Completed'" @click="reject(props.item.id)"
                                       color="red">reject
                                </v-btn>
                            </td>

                            <td v-else>

                                <v-btn v-if="props.item.status =='Incompleted'" @click="start(props.item.id)"
                                       color="blue">start
                                </v-btn>


                                <template v-if="props.item.status =='In progress'">
                                    <v-layout row justify-center>
                                        <v-dialog v-model="dialog" persistent max-width="300px">
                                            <template v-slot:activator="{ on }">
                                                <v-btn color="success" dark v-on="on">mark as complited</v-btn>
                                            </template>
                                            <v-card>
                                                <v-card-title>
                                                    <span class="headline">Completed</span>
                                                </v-card-title>
                                                <v-card-text>
                                                    <v-container grid-list-md>
                                                        <v-layout wrap>
                                                            <v-flex xs12>
                                                                <v-text-field v-model="final_link"
                                                                              label="link"></v-text-field>
                                                            </v-flex>
                                                        </v-layout>
                                                    </v-container>

                                                </v-card-text>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn color="blue darken-1" flat @click="dialog = false">Close
                                                    </v-btn>
                                                    <v-btn color="blue darken-1" flat @click="completed(props.item.id)">
                                                        Save
                                                    </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                    </v-layout>
                                </template>
                            </td>

                        </template>
                    </v-data-table>
                </v-flex>

            </v-layout>
        </v-container>

    </v-container>
</v-flex>
</template>

<script>
 import User from "../../Helpers/User";
    export default {
        data() {
            return {

                final_link: '',
                user :User,
                dialog: false,
                headers: [
                    {text: 'Project', value: 'project'},
                    {text: 'Task', value: 'category'},
                    {text: 'Affected to', value: 'user'},
                    {text: 'Added by', value: 'created_by'},
                    {text: 'Start Date ', value: 'start_date'},
                    {text: 'Due Date ', value: 'due_date'},
                    {text: 'Completed on ', value: 'completed_on'},
                    {text: 'Comments ', value: 'comments'},
                    {text: 'Status ', value: 'status'},
                    {text: 'Links ', value: 'links'},
                    {text: 'action ', value: 'action'},

                ],


                menu: false,
                menu1: false,
                myRole: '',
                dialog: false,
                form: {
                    id: null,
                    link: '',
                    user_id: '',
                    project_id: '',
                    start_date: '',
                    category: '',
                    due_date: '',
                    description: '',
                    btn_name: 'add'


                },

                search: {user_id: null, project_id: null, category_id: null, token: ''},
                categories: [],
                tasks: [],
                users: [],
                status: ['In progress', 'Validated', 'Incompleted', 'Completed'],
                projects: [],
                editSlugt: null,
                errors: null
            }
        },
        created() {

            this.myRole = localStorage.getItem('role');

            this.getData();

            axios.get('/api/category').then(res => this.categories = res.data.data);
            axios.get('/api/project').then(res => this.projects = res.data);
            axios.get('/api/user').then(res => this.users = res.data)
        },

        methods: {

            submit() {
                this.form.id ? this.update() : this.add()
            },
            update() {

                if (this.formValidated()){

                    axios.put(`/api/task/${this.form.id}`, this.form)
                        .then(res => {

                            this.getData();
                            this.$swal('Success', res.data, 'success')
                        }).catch(error => this.$swal('Error', error.response.data.error, 'error'))
                }else{

                    this.$swal('Error', 'Missing columns', 'error')

                }



            },

            filter() {


                this.search.token = localStorage.getItem('token');

                axios.get('/api/task', {
                    params: this.search
                })
                    .then(res => this.tasks = res.data);


            },

            add() {

              if (this.formValidated()){


                  axios.post('/api/task?token=' + localStorage.getItem('token'), this.form).then(res => {
                      console.log(res);
                      this.getData();
                      this.$swal('Success', res.data, 'success');
                  }).catch(error => this.$swal('Error', error.response.data.error, 'error'));
              }else{

                  this.$swal('Error', 'Missing columns', 'error')

              }




            },

            destroy(slug) {
                axios.delete('/api/task/' + slug)
                    .then(res => {
                        this.getData();
                        this.$swal('Success', res.data, 'success')
                    }).catch(error => this.$swal('Error', error.response.data.error, 'error'))
            },

            edit(index) {


                this.form = Object.assign({}, index);
                this.form.btn_name = "update";


            },

            reset() {
                this.form.id = null;
                this.form.link = '';
                this.form.user_id = null;
                this.form.project_id = null;
                this.form.start_date = new Date().toISOString().substr(0, 10);
                this.form.category_id = null;
                this.form.due_date = new Date().toISOString().substr(0, 10);
                this.form.description = '';
                this.form.btn_name = "add";

                this.search.category_id = null;
                this.search.user_id = null;
                this.search.status = null;
                this.search.project_id = null;

            },

            start(id) {
                axios.post('/api/tasks/start?token=' + localStorage.getItem('token'), {id: id})
                    .then(res => {
                        console.log(res);

                        this.getData();
                    });
            },
            completed(id) {

                axios.post('/api/tasks/completed?token=' + localStorage.getItem('token'), {
                    id: id,
                    link: this.final_link
                })
                    .then(res => {

                        this.getData();
                        this.dialog = false;
                    });
            },

            accept(id) {
                axios.post('/api/tasks/accept?token=' + localStorage.getItem('token'), {id: id})
                    .then(res => {
                        console.log(res);

                        this.getData();
                    });
            },
            reject(id) {

                axios.post('/api/tasks/reject?token=' + localStorage.getItem('token'), {id: id, link: this.final_link})
                    .then(res => {

                        this.getData();
                        this.dialog = false;
                    });
            },

            getData() {

                axios.get('/api/task?token=' + localStorage.getItem('token'))
                    .then(res => this.tasks = res.data);
                this.reset();
            },

            formValidated() {

           if(!this.user.admin() && !this.user.coordinator()) {

     console.log(this.user.id());
                     this.form.user_id=this.user.id();
                 }


                return (this.form.category_id != null && this.form.project_id != null && this.form.user_id != null && this.form.start_date != null && this.form.due_date != null);

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
</style>
