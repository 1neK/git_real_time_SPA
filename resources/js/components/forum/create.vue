<template>
    <v-container>
            <v-form @submit.prevent="create">
                <span class="red--text" v-if="errors.title">{{errors.title[0]}}</span>
                <v-text-field
                    v-model="form.title"
                    label="Title"
                    type="text"
                 required
                ></v-text-field>

                <span class="red--text" v-if="errors.category_id">{{errors.category_id[0]}}</span>
                <v-autocomplete
                :items="categories"
                 item-text="name"
                  item-value="id"
                 v-model="form.category_id"
                 label="Category"


                >
                </v-autocomplete>
        <span class="red--text" v-if="errors.body">{{errors.body[0]}}</span>
        <markdown-editor v-model="form.body"  ></markdown-editor>


        <v-btn
        color="green"
        type="submit"
         :disabled="disabled"
         >Create</v-btn>

            </v-form>
</v-container>

</template>

<script>
//import navbar from '../Navbar'
export default {
    data(){
        return {
            form:{
                title:null,
                category_id:null,
                body:null

            },
            categories:{},
            errors:{}
        }
    },
    created(){
        axios.get('/api/category')
        .then(res => this.categories = res.data.data)

    },
    methods:{
        create(){
                axios.post('/api/question',this.form)
                .then(res => this.$router.push(res.data.path) )
                .catch(error => this.errors = error.response.data.errors)
        }
    },
    computed:{
        disabled(){
            return !(this.form.title && this.form.body && this.form.category_id)
        }
    }

}
</script>

<style>
.container {
  max-width: 960px;
}
</style>
