<template>
  <v-layout row wrap>
    <v-container>
    <v-flex xs12>
        <h4>Task</h4>
    </v-flex>
    <v-flex xs12>
      <v-card>
            <v-container>
                <v-toolbar flat color="white">
                        <v-spacer></v-spacer>
                        <v-btn icon>
                            <v-icon medium color="orange">edit</v-icon>
                        </v-btn>
                    </v-toolbar>
                <v-flex md6>
                    <v-subheader>
                        <v-card-text class="py-1"><h5>Affected To:</h5></v-card-text>
                    </v-subheader>
                    <v-subheader>
                        <v-card-text class="py-1"><h5>Start Date:</h5></v-card-text>
                        <v-card-text class="py-1"><h5>Due Date:</h5></v-card-text>
                    </v-subheader>
                    <v-subheader>
                        <v-card-text class="py-1"><h5>Status:</h5></v-card-text>
                    </v-subheader>
                    <v-subheader>
                        <v-card-text class="py-1"><h5>Description:</h5></v-card-text>
                    </v-subheader>

                </v-flex>
            </v-container>

        <v-card-actions>
            <v-spacer></v-spacer>
            <h5>Added By: &nbsp;</h5><p> name </p>
        </v-card-actions>
      </v-card>
    </v-flex>
    </v-container>
    <v-container>
            <v-form @submit.prevent="create">
                <span class="red--text" v-if="errors.body">{{errors.body[0]}}</span>
                <markdown-editor v-model="form.body"  ></markdown-editor>
        <v-btn
        color="green"
        type="submit"
         :disabled="disabled"
         >Create</v-btn>
        </v-form>
</v-container>

  </v-layout>
</template>

<script>
    export default {
  data(){
        return {
            form:{

                body:null

            },
            errors:{}
        }
    },

    methods:{
        create(){
                axios.post('/api/task/{$id}',this.form)
                .then(res => this.$router.push(res.data.path) )
                .catch(error => this.errors = error.response.data.errors)
        }
    },
    computed:{
        disabled(){
            return !(this.form.body)
        }
    }
}
</script>

<style>
.container {
  max-width: 960px;

}
</style>
