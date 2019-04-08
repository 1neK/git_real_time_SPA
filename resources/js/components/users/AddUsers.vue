<template>
    <div class="text-xs-right">
        <v-dialog  v-model="dialog" width="500">

            <template v-slot:activator="{ on }">

                <v-card-text style="height: 100px; position: relative">

                    <v-btn
                            v-on="on"
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
            </template>


            <v-card>
                <v-form @submit.prevent="submit">
                    <v-card-title
                            class="headline grey lighten-2"
                            primary-title
                    >
                        <v-icon x-large>supervisor_account</v-icon>
                    </v-card-title>

                    <v-card-text>
                        <v-text-field
                                label="name"
                                v-model="form.name"
                                type="text"
                                required
                        ></v-text-field>
                        <!--<span class="red--text" v-if="errors.name" >{{errors.name[0]}}</span>-->

                        <v-text-field
                                v-model="form.email"
                                label="Email"
                                type="email"
                                required
                        ></v-text-field>
                        <!--<span class="red--text" v-if="errors.email" >{{errors.email[0]}}</span>-->
                        <v-text-field
                                v-model="form.password"
                                type="password"
                                label="Password"
                                required
                        ></v-text-field>
                        <!--<span class="red--text" v-if="errors.password" >{{errors.password[0]}}</span>-->
                        <v-text-field
                                v-model="form.password_confirmation"
                                type="password"
                                label="Password"
                                required
                        ></v-text-field>

                        <v-flex xs12>
                            <v-combobox
                                    v-model="select"
                                    :items="items"
                                    chips
                                    label="status"
                            ></v-combobox>
                        </v-flex>

                        <v-flex xs12>
                            <v-combobox
                                    v-model="select1"
                                    :items="items1"
                                    label="Role"
                            ></v-combobox>
                        </v-flex>

                        <input
                                type="file"
                                label="file"
                                @change="onFileSelected">


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
                        <v-btn type="submit" :disabled="disabled" color="cyan" v-if="editSlugt">Update</v-btn>

                        <v-btn type="submit" :disabled="disabled" color="teal" v-else>Create</v-btn>
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
                select: 'Active',
                select1: 'Programming',
                items: [
                    'Active',
                    'Inactive',
                ],
                items1: [
                    'Programming',
                    'Design',
                    'coordination',
                    'administration'
                ],
                dialog: false,
                form: {
                    name: null
                },
                roles: {},
                editSlugt: null,
                errors: null,
                selectedFile: null
            }
        },
        created() {
            if (!User.admin()) {
                this.$router.push('/forum')
            }
            axios.get('/api/role')
                .then(res => this.roles = res.data.data)
        },
        methods: {
            onFileSelected(event) {
                this.selectedFile = event.target.files[0]
            },
            submit() {
                this.editSlugt ? this.update() : this.create()
            },
            update() {
                axios.post(`/api/role/${this.editSlugt}`, this.form)
                    .then(res => {
                        this.roles.unshift(res.data)
                        this.form.name = null
                    })
            },
            create() {
                axios.post('/api/role', this.form)
                    .then(res => {
                        this.roles.unshift(res.data)
                        this.form.name = null
                    })
                    .catch(error => this.errors = error.response.data.errors)
            },
            destroy(slug, index) {
                axios.delete(`/api/role/${slug}`)
                    .then(res => this.roles.splice(index, 1))
            },
            edit(index) {

                this.form.name = this.roles[index].name
                this.editSlugt = this.roles[index].slug
                this.roles.splice(index, 1)

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
