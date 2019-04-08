<template>
<div>
<h2>Tasks</h2>
<v-container>

            <v-alert v-if="errors" type="error" :value="true" >
                Task name is required.
            </v-alert>

        <v-form @submit.prevent="submit">

            <v-text-field
            label="Task Name"
            v-model="form.name"
            required
          ></v-text-field>



          <v-btn type="submit" :disabled="disabled" color="cyan" v-if="editSlugt">Update</v-btn>

          <v-btn type="submit" :disabled="disabled" color="teal" v-else>Create</v-btn>

        </v-form>
    </v-container>
</div>
</template>

<script>
export default {
    data(){
        return{
            form:{
                name:null
            },
            //roles:{},
            editSlugt:null,
            errors:null
        }
    },
        created(){
            if(!User.admin()){
                this.$router.push('/forum')
            }
        axios.get('/api/task')
            .then(res => this.tasks = res.data.data)
    },
    methods:{
        submit(){
            this.editSlugt  ?  this.update() : this.create()
        },
        update(){
            axios.post(`/api/task/${this.editSlugt}`,this.form)
            .then(res =>{
                    this.tasks.unshift(res.data)
                    this.form.name = null
                })
        },
        create(){
            axios.post('/api/task',this.form)
                .then(res =>{
                    this.tasks.unshift(res.data)
                    this.form.name = null
                })
                .catch(error => this.errors = error.response.data.errors)
        },
        destroy(slug, index){
            axios.delete(`/api/task/${slug}`)
                .then(res => this.tasks.splice(index,1))
        },
        edit(index){

            this.form.name = this.tasks[index].name
            this.editSlugt = this.tasks[index].slug
            this.tasks.splice(index,1)

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

</style>
