<template>
    <v-container>
        <v-container fluid grid-list-md >
            <v-layout row wrap>
                <v-flex md12 xs12 md1>
                    <h2>Task</h2>
                </v-flex>

                <v-flex md3>
                    <v-card-text class="px-0">Project</v-card-text>
                    <v-select
                        :items="projects"
                        v-model="form.project_id"
                        item-text="name"
                        item-value="id"
                        label="project"
                    ></v-select>

                    <v-card-text class="px-0">Start Date</v-card-text>
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

                        <v-card-text class="px-0">Due Date</v-card-text>
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

                <v-flex md3>
                    <v-card-text class="px-0">Task Type</v-card-text>
                    <v-select
                        :items="categories"
                        v-model="form.category_id"
                        item-text="name"
                        item-value="id"
                    label="task type"
                    ></v-select>

                    <v-card-text class="px-0">Affected To</v-card-text>
                    <v-select
                    :items="users"
                    label="affected to"
                    v-model="form.user_id"
                    item-text="name"
                    item-value="id"
                    ></v-select>

                    <v-card-text class="px-0">Link</v-card-text>
                    <v-text-field
                    v-model="form.link"
                    label="link"
                    ></v-text-field>
                </v-flex>

                <v-flex md6>
                    <v-card-text class="px-0">Description</v-card-text>
                    <v-textarea
                    outline
                    v-model="form.description"
                    name="input-7-4"
                    ></v-textarea>


                </v-flex>

                <v-flex md12 text-xs-center>

                    <v-btn dark @click="submit()">{{form.btn_name}}</v-btn>

                    <v-btn dark @click="reset()">reset</v-btn>

                </v-flex>




                <v-flex xs12 >
                    <v-expansion-panel popout>
                        <v-expansion-panel-content>
                            <template v-slot:header>
                                <div>   <h4>Filter task</h4></div>
                            </template>
                            <v-layout  row wrap p4>

                                <v-flex md4>
                                    <v-card-text class="px-0">Project</v-card-text>
                                    <v-select
                                        :items="projects"
                                        v-model="filter.project_id"
                                        item-text="name"
                                        item-value="id"
                                        label="project"
                                    ></v-select>

                                    <v-card-text class="px-0">Title</v-card-text>
                                    <v-select
                                        :items="type"
                                        v-model="filter.type"
                                        label="title"
                                    ></v-select>
                                </v-flex>

                                <v-flex md4>
                                    <v-card-text class="px-0">Affected To</v-card-text>
                                    <v-select
                                        :items="users"
                                        label="affected to"
                                        v-model="filter.user_id"
                                        item-text="name"
                                        item-value="id"
                                    ></v-select>

                                    <v-card-text class="px-0">Status</v-card-text>
                                    <v-select
                                        :items="users"
                                        label="status"
                                        v-model="filter.user_id"
                                        item-text="name"
                                        item-value="id"
                                    ></v-select>
                                </v-flex>

                                <v-flex md4>
                                    <v-card-text class="px-0">Sort by</v-card-text>
                                    <v-select
                                        :items="projects"
                                        v-model="filter.project_id"
                                        item-text="name"
                                        item-value="id"
                                        label="sort by"
                                    ></v-select>
                                </v-flex>

                            </v-layout>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-flex>

                <v-flex md12 xs12 md1>

                </v-flex>


                <v-container>
                <v-data-table colmd12  :headers="headers" :items="tasks" class="elevation-1">
                    <template v-slot:items="props">
                        <td>{{ props.item.project }}</td>
                        <td class="text-center"> {{ props.item.category_id }}</td>
                        <td class="text-center"> {{ props.item.user }}</td>
                        <td class="text-center"> {{ props.item.createdBy }}</td>
                        <td class="text-center">{{ props.item.start_date }}</td>
                        <td class="text-center">{{ props.item.due_date }}</td>
                        <td class="text-center">{{ props.item.completed_on }}</td>
                        <td class="text-center">{{ props.item.comments }}</td>
                        <td class="text-center">{{ props.item.status }}</td>
                        <td class="text-center">{{ props.item.links }}</td>
                        <td class="text-center">

                            <router-link  :to="{ name: 'task-single', params: { id:  props.item.id } }"  >
                                go to
                            </router-link>


                            <v-btn icon @click="edit(props.item)">
                                <v-icon medium color="black">edit</v-icon>
                            </v-btn>
                            <v-btn icon @click="destroy( props.item.id )">
                                <v-icon medium color="black"> delete</v-icon>
                            </v-btn>
                        </td>
                    </template>
                </v-data-table>
                </v-container>

            </v-layout>
        </v-container>

    </v-container>

</template>

<script>
    export default {
        data() {
            return {
                headers: [
                    {
                        text: 'Project',
                        sortable: false,
                        value: 'project'
                    },


                    {text: 'Task', value: 'category'},
                    {text: 'Affected to', value: 'user'},
                    {text: 'Added by', value: 'createdBy'},
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
                dialog: false,
                form: {
                    id:null,
                    link: '',
                    user_id:null,
                    project_id:null,
                    start_date: new Date().toISOString().substr(0, 10),
                    category_id:null,
                    due_date:  new Date().toISOString().substr(0, 10),
                    description:'',
                    btn_name:'add'


                },

                filter: {
                    id:null,
                    link: '',
                    user_id:null,
                    project_id:null,
                    start_date: new Date().toISOString().substr(0, 10),
                    category_id:null,
                    due_date:  new Date().toISOString().substr(0, 10),
                    description:'',
                    btn_name:'add'


                },
                categories: [],
                tasks: [],
                users: [],
                projects: [],
                editSlugt: null,
                errors: null
            }
        },
        created() {

         this.getData();

            axios.get('/api/category').then(res => this.categories = res.data.data);
            axios.get('/api/project').then(res => this.projects = res.data);
            axios.get('/api/user').then(res => this.users = res.data)
        },

        methods: {

            submit(){
                this.form.id  ?  this.update() : this.add()
            },
            update(){
                axios.put(`/api/task/${this.form.id}`,this.form)
                    .then(res =>{

                        this.getData();
                    })
            },

            add(){

                console.log(this.form);
                 axios.post('/api/task?token='+localStorage.getItem('token'),this.form).then(res => {console.log(res);this.getData(); });



            },

            destroy(slug) {
                axios.delete(`/api/task/${slug}`)
                    .then(res => this.getData())
            },

            edit(index) {



                this.form = Object.assign({},index);
                this.form.btn_name="update";



            },

              reset() {
                    this.form.id=null;
                    this.form.link= '';
                    this.form.user_id=null;
                    this.form.project_id=null;
                    this.form.start_date= new Date().toISOString().substr(0, 10);
                    this.form.category_id=null;
                    this.form.due_date=  new Date().toISOString().substr(0, 10);
                    this.form. description='';
                    this.form.btn_name="add";

        },

            getData(){

   axios.get('/api/task?token='+localStorage.getItem('token'))
                .then(res => this.tasks = res.data);
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
</style>
