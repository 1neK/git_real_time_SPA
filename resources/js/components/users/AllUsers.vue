<template>
    <div class="">

        <v-data-table colmd12 :headers="headers" :items="teams" class="elevation-1">
            <template v-slot:items="props">
                <td>{{ props.item.id }}</td>
                <td class="text-center">{{ props.item.name }}</td>
                <td class="text-center">{{ props.item.email }}</td>
                <td class="text-center">



                    <v-chip color="blue" text-color="white">{{ props.item.status }}</v-chip>


                </td>
                <td class="text-center">{{ props.item.roles }}</td>
                <td class="text-center">
                <td class="text-center">



                    <v-btn flat @click="edit(props.item)">
                        <v-icon large color="green">edit</v-icon>
                    </v-btn>
                    <v-btn flat @click="destroy( props.item.id )">
                        <v-icon color="red"> delete</v-icon>
                    </v-btn>
                </td>

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
                        <v-btn type="submit" :disabled="disabled" color="cyan"  v-if="form.id">Update</v-btn>

                        <v-btn type="submit" :disabled="disabled" color="teal"   v-else>Create</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                headers: [
                    {
                        text: 'id',
                        sortable: false,
                        value: 'name'
                    },
                    {text: 'name', value: 'name'},
                    {text: 'email', value: 'email'},
                    {text: 'status ', value: 'status'},
                    {text: 'role ', value: 'role'},

                    {text: 'action ', value: 'action'},

                ],


                status:['Pending','Active','Banned'],

                roles :[],
                teams: [],
                dialog: false,
                form: {
                    id: null,
                    name: null,
                    password:null,
                    role_id: null,
                    email: null,
                    status: null,
                    btn_name:'add'
                },
                editSlugt: null,
                errors: null
            }
        },
        created() {

            this.getData();

            axios.get('/api/count-team')
                .then(res => this.roles = res.data);

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
                this.form.name = null;
                this.form.password =null;
                this.form.role_id = null;
                this.form.status = null;
                this.form.email = null;


            },

            getData() {


                axios.get('/api/user')
                    .then(res => this.teams = res.data)

                this.reset();

            }

        },

    }
</script>

<style>

</style>
