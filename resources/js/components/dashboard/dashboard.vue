<template>
    <v-container>
        <v-container fluid grid-list-md>
            <v-layout row wrap>
                <v-flex md2 xs3>
                    <h2 class="title font-weight-bold">Dashboard</h2>
                </v-flex>

                <v-flex md1 xs3>
                    <v-card-text class="px-0 font-weight-bold" id="pro"><h4> Filter </h4></v-card-text>
                </v-flex>



                <v-flex md2 xs4>
                    <v-card-text class="px-0 font-weight-bold" id="pro">Project</v-card-text>
                    <v-select
                            v-model="search.project_id"
                            :items="projects"
                            item-text="name"
                            item-value="id"
                            placeholder="Project"
                    ></v-select>
                </v-flex>
                <v-flex md2 xs5 v-if="myRole=='Admin' || myRole=='Coordinator'">
                    <v-card-text class="px-0 font-weight-bold" id="pro">Affected To</v-card-text>
                    <v-select

                            v-model="search.user_id"
                            :items="users"
                            item-text="name"
                            item-value="id"
                            placeholder="Affected To"
                    ></v-select>
                </v-flex>


                <v-flex md2 xs5>
                    <v-card-text class="px-0 font-weight-bold" id="pro">Month</v-card-text>
                    <v-select
                            v-model="search.month"
                            :items="months"
                            item-text="value"
                            item-value="id"
                            placeholder="Month"
                    ></v-select>

                </v-flex>

                <v-flex md2 xs5>
                    <v-card-text class="px-0 font-weight-bold" id="pro">Year</v-card-text>
                    <v-combobox
                            v-model="search.year"
                            :items="years"
                            placeholder="Year"
                    ></v-combobox>
                </v-flex>
                <v-flex md3 xs5></v-flex>
                <v-flex md2 xs5>
                    <v-card-text class="px-0 font-weight-bold" id="pro">Status</v-card-text>
                    <v-select
                            v-model="search.status"
                            :items="status"
                            placeholder="Status"
                    ></v-select>

                </v-flex>
                <v-flex md7></v-flex>
                <v-flex xs1></v-flex>
                <v-flex md6>
                    <v-btn @click="filter()" >filter</v-btn>
                    <v-btn @click="getData()">reset</v-btn>
                </v-flex>

            </v-layout>
            <v-layout wrap row>
                <v-flex md3>
                    <v-hover>
                        <v-card
                                slot-scope="{ hover }"
                                :class="`elevation-${hover ? 12 : 2}`"
                                class="mx-auto"
                                width="300"
                        >
                            <v-card-title>
                                <div md6>
                                    <v-flex>
                                        <v-flex>
                                            <v-icon color="#188EF5">check_circle</v-icon>  {{stats.validated}}
                                        </v-flex>
                                        <v-flex>
                                            Total Validated :
                                        </v-flex>
                                    </v-flex>
                                    <v-flex>
                                        <v-flex>
                                            <v-icon color="#35851E">check_circle</v-icon> {{stats.completed}}
                                        </v-flex>
                                        <v-flex>
                                            Total Completed
                                        </v-flex>
                                    </v-flex>
                                    <v-flex>
                                        <v-flex>
                                            <v-icon color="#35851E">check_circle</v-icon> {{stats.all}}
                                        </v-flex>
                                        <v-flex>
                                            Total
                                        </v-flex>
                                    </v-flex>
                                </div>
                                <v-flex md6>
                                    <v-flex>
                                        <v-card-text class="py-1 font-weight-bold"><h1> % <small>{{stats.prod}}</small></h1></v-card-text>
                                    </v-flex>
                                    <v-flex>
                                        Productivity
                                    </v-flex>
                                </v-flex>
                                <v-spacer></v-spacer>
                            </v-card-title>
                        </v-card>
                    </v-hover>
                </v-flex>
                <!--<v-spacer></v-spacer>-->
                <v-flex xs6></v-flex>
                <v-flex xs8></v-flex>
                <v-flex md4 xs10>

                <download-excel
	            class   = "btn btn-default"
	            :data   = "tasks"
	            :fields = "json_fields"
	            worksheet = "My Worksheet"
	            name    = "filename.xls">

                    <v-btn color="#43425D" class="btdown" > Download Excell</v-btn>

                </download-excel>
                </v-flex>

                <v-flex md11 xs12 sm10>
                    <v-data-table colmd12 :headers="headers" :items="tasks" class="elevation-1">
                        <template v-slot:items="props">
                            <td>{{ props.item.project }}</td>
                            <td class="text-center">{{ props.item.category }}</td>
                            <td class="text-center">{{ props.item.user }}</td>
                            <td class="text-center">{{ props.item.start_date }}</td>
                            <td class="text-center">{{ props.item.due_date }}</td>
                            <td class="text-center">{{ props.item.date_completed }}</td>
                            <td class="text-center">{{ props.item.comments }}</td>
                            <td class="text-center">{{ props.item.status }}</td>
                            <td class="text-center">{{ props.item.final_link }}</td>
                        </template>
                    </v-data-table>
                </v-flex>


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
                    {text: 'Start Date ', value: 'start_date'},
                    {text: 'Due Date ', value: 'due_date'},
                    {text: 'Completed on ', value: 'date_completed'},
                    {text: 'Comments ', value: 'comments'},
                    {text: 'Status ', value: 'status'},
                    {text: 'Links ', value: 'final_link'},

                ],

                users: [],
                projects:[],
                categories:[],
                tasks:[],
                status:['In progress','Validated','Incompleted','Completed','all'],

                search:{user_id:null,project_id:null,year:null,month:null,token:'',status:null},

                years: [],
                stats: [],

                myRole:null,

                months: [
                    {id:'01' ,value:'January'},
                    {id:'02' ,value: 'February'},
                    {id:'03' ,value: 'March'},
                    {id:'04' ,value: 'April'},
                    {id:'05' ,value: 'May'},
                    {id:'06' ,value: 'June'},
                    {id:'07' ,value: 'July'},
                    {id:'08' ,value: 'August'},
                    {id:'09' ,value: 'September'},
                    {id:'10' ,value: 'October'},
                    {id:'11' ,value: 'November'},
                    {id:'12' ,value: 'December'}],

                    json_fields: {
                        'project': 'project',
                        'Task': 'category',
                        'Affected to': 'user',
                        'start date':'start_date',
                        'due date':'due_date',
                        'status':'status',
                        'Completed on ': 'date_completed',
                        'Links ': 'final_link'
            },


        json_meta: [
            [
                {
                    'key': 'charset',
                    'value': 'utf-8'
                }
            ]
        ],

            }

        },


        created() {


            this.myRole =localStorage.getItem('role');


            this.getData();


        },
        methods: {

            getData(){
                axios.get('/api/project').then(res => this.projects = res.data);

                axios.get('/api/task/allyears').then(res => this.years = res.data);
                axios.get('/api/user').then(res => this.users = res.data);
                axios.get('/api/dashboard?token='+localStorage.getItem('token')).then(res => this.tasks = res.data);
                axios.get('/api/dashboard/stats').then(res => this.stats = res.data);

                this.search.project_id = null;
                this.search.year = null;
                this.search.month = null;
                this.search.user_id =null;
                this.search.status =null;

            },

            filter(){

                this.search.token=localStorage.getItem('token');
                axios.get('/api/dashboard',{params:this.search})
                    .then(res => this.tasks = res.data)


            }

        }

    }
</script>

<style>
    .container {
        max-width: 960px;
    }
    .btdown{
        border: none;
        color: #fff !important;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        padding: 10px 24px;
        border-radius: 12px;
    }
    #pro1{
        color:black;
    }

</style>
