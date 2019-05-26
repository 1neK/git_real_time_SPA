<template>

    <v-container>

            <v-alert v-if="errors" type="error" :value="true" >
                Category name is required.
            </v-alert>

        <v-form @submit.prevent="submit">

            <v-text-field
            placeholder="Task Type"
            v-model="form.name"
            required
            autofocus
          ></v-text-field>

          <v-btn type="submit" :disabled="disabled" color="#188EF5" v-if="editSlug">Update</v-btn>

          <v-btn type="submit" :disabled="disabled" color="#5FD179" v-else>Create</v-btn>

        </v-form>

        <v-layout>
        <v-flex xs12 sm8 offset-sm2>
        <v-card class="text-xs-center">
             <v-toolbar color="grey darken-1" dark dense>
          <v-toolbar-title>Task Types</v-toolbar-title>
        </v-toolbar>

        <v-list >
            <div v-for="(category,index) in categories" :key="category.id">
                <v-list-tile>

                <v-list-tile-content>
                    <v-list-tile-content>
                        {{category.name}}
                    </v-list-tile-content>
                </v-list-tile-content>

                <v-list-tile-action>
                    <v-btn icon small @click="edit(index)">
                        <v-icon color="orange">create</v-icon>
                    </v-btn>
                </v-list-tile-action>


                <v-list-tile-action icon small @click="destroy(category.slug,index)">
                    <v-btn icon small>
                        <v-icon color="#F5181F">delete_forever</v-icon>
                    </v-btn>
                </v-list-tile-action>
            </v-list-tile>
            <v-divider></v-divider>
            </div>

        </v-list>

        </v-card>
        </v-flex>
        </v-layout>
    </v-container>

</template>

<script>
export default {
    data(){
        return{
            form:{
                name:null
            },
            categories:{},
            editSlug:null,
            errors:null
            }
        },
        created(){
            if(!User.admin()){
                this.$router.push('/forum')
            }
        axios.get('/api/category')
            .then(res => this.categories = res.data.data)
    },
    methods:{
        submit(){
            this.editSlug  ?  this.update() : this.create()
        },
        update(){
            axios.patch(`/api/category/${this.editSlug}`,this.form)
            .then(res =>{
                    this.categories.unshift(res.data)
                    this.form.name = null
                })
        },
        create(){
            axios.post('/api/category',this.form)
                .then(res =>{
                    this.categories.unshift(res.data)
                    this.form.name = null
                })
                .catch(error => this.errors = error.response.data.errors)
        },
        destroy(slug, index){
            axios.delete(`/api/category/${slug}`)
                .then(res => this.categories.splice(index,1))
        },
        edit(index){

            this.form.name = this.categories[index].name
            this.editSlug = this.categories[index].slug
            this.categories.splice(index,1)

        }
    },
    computed:{
        disabled(){
            return !(this.form.name)
        }
    }

}
</script>

<style>
.container {
  max-width: 960px;
}
</style>
