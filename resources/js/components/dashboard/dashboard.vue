<template>
    <v-container>
        <v-container fluid grid-list-md>
            <v-layout row wrap>
                <v-flex xs3 md2>
                    <h2>Dashboard</h2>
                </v-flex>

                <v-flex xs3 md10>
                    <v-card-text class="px-0"><h4> Filter </h4></v-card-text>
                </v-flex>



                <v-flex xs2>
                    <v-card-text class="px-0">Project</v-card-text>
                    <v-select
                            v-model="search.project_id"
                            :items="projects"
                            item-text="name"
                            item-value="id"
                            label="project"
                    ></v-select>
                </v-flex>
                <v-flex xs2 v-if="myRole=='Admin' || myRole=='Coordinator'">
                    <v-card-text class="px-0">Affected To</v-card-text>
                    <v-select

                            v-model="search.user_id"
                            :items="users"
                            item-text="name"
                            item-value="id"
                            label="affected to"
                    ></v-select>
                </v-flex>


                <v-flex xs2>
                    <v-card-text class="px-0">Month</v-card-text>
                    <v-select
                            v-model="search.month"
                            :items="months"
                            item-text="value"
                            item-value="id"
                            label="month"
                    ></v-select>

                </v-flex>

                <v-flex xs2>
                    <v-card-text class="px-0">Year</v-card-text>
                    <v-combobox
                            v-model="search.year"
                            :items="years"
                            label="year"
                    ></v-combobox>
                </v-flex>
                <v-flex xs2>
                    <v-card-text class="px-0">staus</v-card-text>
                    <v-select
                            v-model="search.status"
                            :items="status"
                            label="staus"
                    ></v-select>

                </v-flex>
                <v-flex xs3>
                    <v-btn @click="filter()"  >filter</v-btn>
                    <v-btn @click="getData()"  >reset</v-btn>

                </v-flex>
            </v-layout>
            <v-layout wrap row>
                <v-flex xs3>
                    <v-hover>
                        <v-card
                                slot-scope="{ hover }"
                                :class="`elevation-${hover ? 12 : 2}`"
                                class="mx-auto"
                                width="344"
                        >
                            <v-card-title>
                                <div xs6>
                                    <v-flex>
                                        <v-flex>
                                            <v-icon>check_circle</v-icon>  {{stats.validated}}
                                        </v-flex>
                                        <v-flex>
                                            Total Validated :
                                        </v-flex>
                                    </v-flex>
                                    <v-flex>
                                        <v-flex>
                                            <v-icon>check_circle</v-icon> {{stats.validated}}
                                        </v-flex>
                                        <v-flex>
                                            Total Completed
                                        </v-flex>
                                    </v-flex>
                                </div>
                                <v-flex xs6>
                                    <v-flex>
                                        <v-icon>check_circle</v-icon> {{stats.validated}} %
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
                <v-flex xs10></v-flex>
                <v-flex xs2>
                    <v-btn color="grey"> Download Excell</v-btn>
                </v-flex>

                <v-container>
                    <v-data-table colmd12 :headers="headers" :items="tasks" class="elevation-1">
                        <template v-slot:items="props">
                            <td>{{ props.item.project }}</td>
                            <td class="text-center">{{ props.item.type }}</td>
                            <td class="text-center">{{ props.item.user }}</td>
                            <td class="text-center">{{ props.item.start_date }}</td>
                            <td class="text-center">{{ props.item.due_date }}</td>
                            <td class="text-center">{{ props.item.completed_on }}</td>
                            <td class="text-center">{{ props.item.comments }}</td>
                            <td class="text-center">{{ props.item.status }}</td>
                            <td class="text-center">{{ props.item.links }}</td>
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
                /*select1: 'Ins'
                items1: [

                ],*/
                headers: [
                    {
                        text: 'Project',
                        sortable: false,
                        value: 'project'
                    },


                    {text: 'Task', value: 'type'},
                    {text: 'Affected to', value: 'user'},
                    {text: 'Start Date ', value: 'start_date'},
                    {text: 'Due Date ', value: 'due_date'},
                    {text: 'Completed on ', value: 'completed_on'},
                    {text: 'Comments ', value: 'comments'},
                    {text: 'Status ', value: 'status'},
                    {text: 'Links ', value: 'links'},

                ],

                users: [],
                projects:[],

                tasks:[],
                status:['In progress','Validated','Incompleted','Completed'],

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
</style>
