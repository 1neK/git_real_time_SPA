<template>
    <v-container>
        <v-container fluid grid-list-md >
        <v-layout row wrap>
                <v-flex xs3 md2 v-slot:header>
                    <h2>Users</h2>
                </v-flex>

            <v-flex xs3 md10>
                    <v-card-text class="px-0"> <h4> Filter user </h4> </v-card-text>
            </v-flex>

            <v-flex xs3>
                    <v-card-text class="px-0">Name</v-card-text>
                <v-text-field label="Name" v-model="search.name"></v-text-field>
            </v-flex>
            <v-flex xs3>
                    <v-card-text class="px-0">Role</v-card-text>
                    <v-select
                    :items="roles"
                    label="role"
                    v-model="search.role_id"
                    item-text="name"
                    item-value="id"
                    ></v-select>
            </v-flex>
            <v-flex xs3>
                <v-card-text class="px-0">Status</v-card-text>
                    <v-select
                    :items="users"
                    label="status"
                    v-model="search.status"
                    item-text="status"

                    ></v-select>
            </v-flex>
            <v-flex xs3>
                <v-btn @click="filter()"  >filter</v-btn>
                <v-btn @click="getData()"  >reset</v-btn>

            </v-flex>

        </v-layout>
        </v-container>
        <v-data-table colmd12 :headers="headers" :items="teams" class="elevation-1">
            <template v-slot:items="props">
                <td>{{ props.item.id }}</td>
                <td class="text-center">{{ props.item.name }}</td>
                <td class="text-center">{{ props.item.email }}</td>
                <td class="text-center">{{ props.item.created_at }}</td>
                <td class="text-center">{{ props.item.last_connexion }}</td>
                <td class="text-center">{{ props.item.roles }}</td>
                <td class="text-center">
                    <v-chip color="blue" text-color="white">{{ props.item.status }}</v-chip>
                </td>
                <td class="text-center">
                    <v-btn icon @click="edit(props.item)">
                        <v-icon medium color="black">edit</v-icon>
                    </v-btn>
                    <v-btn icon @click="destroy( props.item.id )">
                        <v-icon medium color="black"> delete</v-icon>
                    </v-btn>
                </td>

            </template>
        </v-data-table>
        <v-dialog v-model="dialog" width="700">
            <template v-slot:activator="{ on }">
                <v-card-text class="text-right" style="height: 100px; position: relative">

                    <v-btn
                            v-on="on"
                            @click="reset()"
                            absolute
                            dark
                            fab
                            top
                            right
                            color="pink"

                    >
                        <v-icon>add</v-icon>
                    </v-btn>
                </v-card-text>

                <v-layout row wrap>


                </v-layout>
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

                        <v-layout row wrap>

                        <v-flex md6>
                            <v-text-field
                                    label="name"
                                    v-model="form.name"
                                    type="text"
                                    required
                            ></v-text-field>

                        </v-flex>

                            <v-flex md6>
                                <v-text-field
                                        v-model="form.password"
                                        type="password"
                                        name="password"
                                        label="password"
                                ></v-text-field>

                            </v-flex>

                            <v-flex md6>

                                <v-select
                                        :items="roles"
                                        v-model="form.role_id"
                                        item-text="name"
                                        item-value="id"
                                        label="role"
                                ></v-select>
                            </v-flex>
                        <v-flex md6>

                            <v-select
                                    :items="status"
                                    v-model="form.status"
                                    label="status"
                            ></v-select>
                        </v-flex>


                        <v-flex md6>


                        <v-text-field
                                label="email"
                                v-model="form.email"
                                type="email"
                                required
                        ></v-text-field>

                        </v-flex>
                        </v-layout>

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
                        <v-btn type="submit" color="cyan"  v-if="form.id">Update</v-btn>

                        <v-btn type="submit" color="teal"   v-else>Create</v-btn>
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
                form: {
                id: null,
                name: null,
                btn_name: 'create'
            },
            users:{},
                headers: [
                    {
                        text: 'ID',
                        sortable: false,
                        value: 'name'
                    },
                    {text: 'Name', value: 'name'},
                    {text: 'Email', value: 'email'},
                    {text: 'Created at', value: 'created_at'},
                    {text: 'Last connexion', value: 'last_connexion'},
                    {text: 'Role ', value: 'role'},
                    {text: 'Status ', value: 'status'},
                    {text: 'Action ', value: 'action'},

                ],


                status:['Pending','Active','Banned'],


                search: {  name: null, role_id: null, status: null},

                roles :[],
                teams: [],
                dialog: false,
                editSlugt: null,
                errors: null
            }
        },
        created() {

            this.getData();

            axios.get('/api/count-team')
                .then(res => this.roles = res.data);
            axios.get('/api/user').then(res => this.users = res.data);

        },
        methods: {

            submit(){
                this.form.id  ?  this.update() : this.add()
            },
            update(){
                axios.put(`/api/user/${this.form.id}`,this.form)
                    .then(res =>{

                        this.getData();
                        this.dialog=false;
                    })
            },

            add(){


                axios.post('/api/user?token='+localStorage.getItem('token'),this.form).then(res => {this.getData();this.dialog=false; } );



            },

            destroy(slug) {
                axios.delete(`/api/user/${slug}`)
                    .then(res => this.getData())
            },


            edit(index) {

                this.dialog= true;


                this.form = Object.assign({}, index);

                this.form.btn_name = "update";


            },

            reset() {
                this.form.id = null;

                this.form.password =null;
                this.form.role_id = null;
                this.form.status = null;
                this.form.email = null;

                this.search.role_id = null;
                this.search.status = null;
                this.search.name = null;

            },

            getData() {


                axios.get('/api/user').then(res => this.teams = res.data)

                this.reset();

            },

            filter(){
                axios.get('/api/user',{params:this.search})
                    .then(res => this.teams = res.data)


            }

        },

    }
</script>

<style>
.container {
  max-width: 960px;
}


</style>
