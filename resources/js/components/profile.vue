<template>
    <v-container
            fill-height
            fluid
            grid-list-xl>
        <v-layout
                justify-center
                wrap
        >
            <v-flex
                    xs12

            >

                <v-form>
                    <v-container py-0>
                        <v-layout wrap>
                            <v-flex
                                    xs12
                                    md6
                            >
                                <v-text-field
                                        label="Team"
                                        v-model="profile.team"
                                        disabled/>
                            </v-flex>
                            <v-flex
                                    xs12
                                    md6
                            >
                                <v-text-field
                                        class="purple-input"
                                        label=" Name"
                                        v-model="profile.name"
                                />
                            </v-flex>
                            <v-flex
                                    xs12
                                    md6
                            >
                                <v-text-field
                                        label="Email Address"
                                        v-model="profile.email"
                                        class="purple-input"/>
                            </v-flex>


                            <v-flex
                                    xs12
                                    md4>
                                <v-text-field
                                        label="Password (keep it blank if you dont want to  change it)"
                                        type="password"
                                        class="purple-input"
                                        v-model="profile.newpassword"
                                />
                            </v-flex>



                            <v-flex
                                    xs12
                                    text-xs-right
                            >
                                <v-btn
                                        class="mx-0 font-weight-light"
                                        color="success"
                                        @click="update()"
                                >
                                    Update Profile
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-form>

            </v-flex>

        </v-layout>
    </v-container>
</template>

<script>
    export default {


        data() {

            return {
                profile: {}

            }
        },
        created() {

            this.init();
        },
        methods: {

            init() {

                axios.get('/api/profile').then(res => this.profile = res.data);
            },

            update(){
                axios.post('/api/profile',this.profile).then(res => Vue.toasted.show(res.data))
            }
        }


    }
</script>

<style scoped>

</style>
