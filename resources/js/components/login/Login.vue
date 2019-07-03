<template>
    <v-container>
        <v-layout>
            <v-flex xs12 md6 sm12  offset-md3>
                <v-card class="text-xs-center" id="card1">
                    <v-card-title primary-title>
                        <div class="center" font-weight-bold>
                            <h1> Login </h1>
                        </div>
                    </v-card-title>
                    <v-form @submit.prevent="login">

                        <v-text-field
                                class="px-1"
                                v-model="form.email"
                                placeholder="Email"
                                type="email"
                                required
                                autofocus
                                required
                        ></v-text-field>

                        <v-text-field
                                class="px-1"
                                v-model="form.password"
                                type="password"
                                placeholder="Password"
                                required
                        ></v-text-field>
                        <v-flex xs12></v-flex>
                        <v-flex xs12></v-flex>
                        <button class="button1" type="submit">Login</button> &nbsp;
                        <router-link to="/signup">
                            <button class="button2">Sign Up</button>
                        </router-link>

                        <v-flex xs12></v-flex>

                    </v-form>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>


<script>

    import User from '../../Helpers/User';
    import AppStorage from '../../Helpers/AppStorage';

    export default {
        data() {
            return {
                form: {
                    email: null,
                    password: null,
                }
            }
        },
        created() {

        },


        methods: {
            validEmail(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            login() {
                if (this.form.password && this.form.email && this.validEmail(this.form.email)) {

                    axios.post('/api/auth/login', this.form)
                        .then(res => {

                            this.responseAfterLogin(res.data)
                        })
                        .catch(error => this.$swal('Error', error.response.data.error, 'error'))

                } else {

                    this.$swal('Error', 'Email and Password are required ', 'error')


                }


            },

            responseAfterLogin(res) {
                const access_token = res.access_token
                const user = res.user;

                if (access_token != '') {

                    AppStorage.storeToken(access_token);
                    AppStorage.storeUser(user.name);

                    AppStorage.storeRole(user.role);

                    EventBus.$emit('login');


                    this.$router.push({name: 'home'});



                }

            }


        }
    }
</script>

<style>
    #card1 {
        padding: 50px 50px;
    }

    .container {
        max-width: 960px;

    }

    .center {
        margin: auto;
        color: #43425D;
    }

    .button1 {
        background-color: #43425D; /* Green */
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
    }

    .button2 {
        background-color: none; /* Green */
        border: 2px solid #43425D;
        color: #43425D;
        padding: 7px 40px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        font-size: 12px;
        border-radius: 2px;
    }
</style>
