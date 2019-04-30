<template>
    <v-container>
        <v-container fluid grid-list-md >
            <v-layout row wrap>
                <v-flex md12 xs12 md1>
                    <h3 class="title font-weight-bold" id="proj">{{project.name}}</h3>
                </v-flex>
                <v-flex xs12 >
                    <v-expansion-panel popout>
                        <v-expansion-panel-content>
                            <template v-slot:header>
                                <div class="font-weight-bold" id="pro">   <h4>Filter task</h4></div>
                            </template>
                            <v-layout  row wrap p4>
                                <v-flex md1></v-flex>
                                <v-flex md3>

                                    <v-card-text class="font-weight-bold" id="pro">Title</v-card-text>
                                    <v-select
                                        :items="categories"
                                        v-model="search.category_id"
                                        item-text="name"
                                        item-value="id"
                                        placeholder="Title"
                                        class="px-1"
                                    ></v-select>
                                </v-flex>

                                <v-flex md3 >
                                    <v-card-text class="font-weight-bold" id="pro">Status</v-card-text>
                                    <v-select
                                        :items="status"
                                        placeholder="Status"
                                        v-model="search.status"
                                        class="px-1"
                                    ></v-select>
                                </v-flex>

                                <v-flex md3>

                                    <v-flex md3>

                                        <v-btn dark @click="filter()">filter</v-btn>

                                    </v-flex>
                                    <v-flex md3>

                                          <v-btn dark @click="getData()">reset</v-btn>

                                    </v-flex>

                                </v-flex>

                            </v-layout>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-flex>

                <v-flex md12 xs12 md1>

                </v-flex>


                <v-container>
                <v-data-table colmd12  :headers="headers" :items="project.tasks" class="elevation-1">
                    <template v-slot:items="props" >
                        <td> <router-link  :to="{ name: 'task-single', params: { id:  props.item.id } }"  > {{ props.item.category_id }} </router-link></td>
                        <td class="text-center"> {{ props.item.user }}</td>
                        <td class="text-center">{{ props.item.start_date }}</td>
                        <td class="text-center">{{ props.item.due_date }}</td>
                        <td class="text-center">{{ props.item.comments }}</td>
                        <td class="text-center"><v-chip :color="color" text-color="white" class="buttonT">{{ props.item.status }} </v-chip> </td>
                        <td class="justify-center layout px-0" v-if="myRole=='Admin' || myRole=='Coordinator'">

                                <v-icon medium color="orange" @click="edit(props.item)">create</v-icon>

                                <v-icon medium color="#F5181F" @click="destroy( props.item.id )"> delete_forever</v-icon>

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

                final_link:'',
                dialog:false,
                headers: [
                    {text: 'Title', value: 'category'},
                    {text: 'Affected to', value: 'user'},
                    {text: 'Start Date ', value: 'start_date'},
                    {text: 'Due Date ', value: 'due_date'},
                    {text: 'Comments ', value: 'comments'},
                    {text: 'Status ', value: 'status'},
                    {text: 'action ', value: 'action'},

                ],


 project:{},
 menu: false,
 menu1: false,
                myRole:'',
                dialog: false,
                form: {
                    id:null,
                    user_id:null,
                    project_id:null,
                    start_date: new Date().toISOString().substr(0, 10),
                    category_id:null,
                    due_date:  new Date().toISOString().substr(0, 10),
                    description:'',
                    btn_name:'add'


                },

                search: { user_id:null,  project_id:null, category_id:null,token:''},
                categories: [],
                tasks: [],
                users: [],
                status:['In progress','Validated','Incompleted','Completed'],
                projects: [],
                editSlugt: null,
                errors: null
            }
        },
        created() {

         this.myRole =localStorage.getItem('role');

         this.getData();

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

            filter(){

                console.log(this.search);

                this.search.token=localStorage.getItem('token');

                axios.get('/api/task',{
                    params:this.search
                })
                    .then(res => this.tasks = res.data);



            },

            add(){

                console.log(this.form);
                 axios.post('/api/task?token='+localStorage.getItem('token'),this.form).then(res => {console.log(res);this.getData(); });



            },

            destroy(slug) {
                axios.delete(`/api/task/${slug}?token=`+localStorage.getItem('token'))
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

                    this.search.category_id=null;
                    this.search.user_id=null;
                    this.search.status=null;
                    this.search.project_id=null;

        },

            start(id){
                axios.post('/api/tasks/start?token='+localStorage.getItem('token'),{id:id})
                    .then(res =>{console.log(res);

                        this.getData();
                    });
            },
            completed(id){

                axios.post('/api/tasks/completed?token='+localStorage.getItem('token'),{id:id,link:this.final_link})
                    .then(res => {

                        this.getData();
                        this.dialog = false;
                    });
            },


            getData(){

                axios.get('/api/project/' + this.$route.params.id)
                .then(res => this.project = res.data)
                axios.get('/api/category').then(res => this.categories = res.data.data);
                axios.get('/api/user').then(res => this.users = res.data)
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
#proj{
    color: #43425D;
}
#pro{
    color: #A3A6B4;
}
</style>
