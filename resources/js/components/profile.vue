<template>
<v-flex flex sm9 xs9>
    <v-container
            fill-height
            fluid
            grid-list-xl>
        <v-layout
                justify-center
                wrap
        >
            <v-flex xs12>

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

                              <v-flex xs12 md4>
                                  <input type="file" name="image"  @change=uploadImage id="">
                              </v-flex>
                              <v-flex xs12 md4>

                                  <v-avatar>
      <img v-bind:src="preview" alt="avatar">
    </v-avatar>
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
</v-flex>
</template>

<script>
    export default {


        data() {

            return {
                profile: {},
                 preview:'',
                image: {},

            }
        },
        created() {

            this.init();
        },
        methods: {

             uploadImage(e) {
                const image = e.target.files[0];
                const reader = new FileReader();
                reader.readAsDataURL(image);
                this.image = image;


                reader.onload = e => {
                    this.preview = e.target.result;
                };
            },

            init() {

                axios.get('/api/profile').then(res => {this.profile = res.data

                this.preview='http://localhost:8000/media/'+this.profile.avatar
                });
            },

            update() {
                   let config= {
                    header : {
                        'Content-Type' : 'image/png'
                    }
                }

                var that = this;
                let formData = new FormData();
                formData.append('image', this.image);
                formData.append('data',JSON.stringify(this.profile) );
                axios.post('/api/profile', formData,config).then(res => Vue.toasted.show(res.data))
            }
        }


    }
</script>

<style scoped>

</style>
