<template>
<v-container>
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
                            label="Standard"
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

                                             label="Picker in menu"
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
                                             label="Picker in menu"

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
                            :items="type"
                            v-model="form.type"
                            label="Standard"
                            ></v-select>

                            <v-card-text class="px-0">Affected To</v-card-text>
                            <v-select
                            :items="users"
                            label="Standard"
                            v-model="form.user_id"
                            item-text="name"
                            item-value="id"
                            ></v-select>

                            <v-card-text class="px-0">Link</v-card-text>
                            <v-text-field
                           v-model="form.link"
                            label="Standard"
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



        </v-layout>
    </v-container>

    </v-container>

<v-container>
    <v-data-table colmd12  :headers="headers" :items="tasks" class="elevation-1">
        <template v-slot:items="props">
            <td>{{ props.item.project }}</td>
            <td class="text-center">{{ props.item.type }}</td>
            <td class="text-center">{{ props.item.user }}</td>
            <td class="text-center">{{ props.item.start_date }}</td>
            <td class="text-center">{{ props.item.due_date }}</td>
            <td class="text-center">{{ props.item.status }}</td>


                <td class="text-center">


                    <v-btn icon @click="edit(props.item)">  <v-icon medium color="green">edit</v-icon></v-btn>
                    <v-btn icon @click="destroy( props.item.id )">
                        <v-icon medium color="red"> delete</v-icon>
                    </v-btn>
                </td>




        </template>
    </v-data-table>
</v-container>
</v-container>
</template>

<script>
    export default {
        data() {
            return {
                headers: [
                    {
                        text: 'project',
                        sortable: false,
                        value: 'project'
                    },


                    {text: 'Task', value: 'type'},
                    {text: 'Affected to', value: 'user'},
                    {text: 'Start Date ', value: 'start_date'},
                      {text: 'Due Date ', value: 'due_date'},
                       {text: 'Status ', value: 'status'},
                    {text: 'action ', value: 'action'},

                ],

type:['Blog','Authentification','Edit Slider','Slider'],

 menu: false,
 menu1: false,
                dialog: false,
                form: {
                    id:null,
                    link: null,
                    user_id:null,
                    project_id:null,
                    start_date: new Date().toISOString().substr(0, 10),
                    type:null,
                    due_date:  new Date().toISOString().substr(0, 10),
                    description:null,
                    btn_name:'add'


                },
                tasks: [],
                users: [],
                projects: [],
                editSlugt: null,
                errors: null
            }
        },
        created() {

         this.getData();


            axios.get('/api/project').then(res => this.projects = res.data.data);
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
                    this.form.link= null;
                    this.form.user_id=null;
                    this.form.project_id=null;
                    this.form.start_date= new Date().toISOString().substr(0, 10);
                    this.form.type=null;
                this.form.due_date=  new Date().toISOString().substr(0, 10);
                   this.form. description=null;
                  this.form.btn_name="add";

        },

            getData(){

   axios.get('/api/task')
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

</style>
