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
        <v-flex xs12>
            <h4>Comments:</h4>
        </v-flex>
        <v-container fluid>
        <v-card>
        <v-form @submit.prevent="update"></v-form>

            <markdown-editor v-model="form.body"  ></markdown-editor>
              <!-- <v-btn color="green" type="submit">Create</v-btn> -->
            <v-card-actions>
                <v-btn icon small type="submit">
                    <v-icon color="teal">save</v-icon>
                </v-btn>
                <v-btn icon small @click="cancel">
                    <v-icon color="teal">cancel</v-icon>
                </v-btn>
            </v-card-actions>
        </v-form>
        </v-card>
    </v-container>
        <v-flex xs12>
        </v-flex>
    </v-container>

  </v-layout>
</template>

<script>
    export default {
 props:['data'],
data(){
    return {
        form : {
            title:null,
            body:null
        }
    }
},
mounted(){
    this.form = this.data
},
methods:{

    cancel(){
        EventBus.$emit('cancelEditing')
    },
    update(){
        axios.patch(`/api/question/${this.form.slug}`,this.form)
        .then(res => this.cancel())
    }
}
}
</script>

<style>
.container {
  max-width: 960px;

}
</style>
