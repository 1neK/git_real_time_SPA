<template>
    <div class="mt-4">
        <markdown-editor v-model="body"></markdown-editor>
        <v-btn dark color="green" @click="submit">
            Reply
        </v-btn>
    </div>
</template>

<script>
export default {
    props:['questionSlug'],
    data(){
        return{
           body:null
        }
    },
    methods:{
        submit(){
            axios.post(`/api/question/${this.questionSlug}/reply`,{body:this.body})
                .then(res => {
                    this.body = ''
                    EventBus.$emit('newReply',res.data.reply)
                    location.reload()
                })
        }
    }

}
</script>

<style>

</style>
