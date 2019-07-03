<template>
    <v-container>
        <v-layout>
            <v-flex flex xs12 md6 offset-md3>
                <v-card class="text-xs-center" id="card1">
                    <v-card-title primary-title>
                        <div class="center" font-weight-bold>
                            <h1> Sign Up </h1>
                        </div>
                    </v-card-title>
                    <v-form @submit.prevent="signup">

                        <v-text-field
                                placeholder="Name"
                                v-model="form.name"
                                type="text"
                                required
                                autofocus
                        ></v-text-field>

                        <v-text-field
                                v-model="form.email"
                                placeholder="Email"
                                type="email"
                                required
                        ></v-text-field>

                        <v-text-field
                                v-model="form.password"
                                type="password"
                                placeholder="Password"
                                required
                        ></v-text-field>

                        <v-text-field
                                v-model="form.password_confirmation"
                                type="password"
                                placeholder="Confirm Password"
                                required
                        ></v-text-field>
                        <v-flex xs12></v-flex>
                        <v-html>
                            <button class="button1" type="submit">Sign Up</button> &nbsp;
                            <router-link to="/login">
                                <button class="button2">Login</button>
                            </router-link>
                        </v-html>


                    </v-form>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    name: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                },
                errors: {name: null, email: null,}

            }

        },
        created() {
            if (User.loggedIn()) {
                this.$router.push({name: 'forum'})
            }

        },

        methods: {
            validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            signup() {
                if (this.form.password && this.form.password_confirmation && this.form.name && this.form.email && this.validEmail(this.form.email)) {
                    axios.post('/api/auth/signup', this.form)
                        .then(res => {
                            if (res.data.success) {
                                this.$swal('Success', res.data.message, 'success')
                            } else {
                                this.$swal('Error', 'This account does already exist please enter another email adress', 'error')
                            }
                        })
                        .catch(error => this.$swal('Error', error.response.data.error, 'error'))
                } else {
                    this.$swal('Error', 'All fields are required ', 'error')
                }


            }
        }
    }
</script>

<style>
    #card1 {
        padding: 50px 40px;
    }

    .container {
        max-width: 960px;
    }

    .center {
        margin: auto;
        color: #43425D;
    }
</style>
