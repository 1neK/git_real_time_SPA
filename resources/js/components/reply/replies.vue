<template>
    <div>
        <reply v-for="(reply, index) in content"
         :key="reply.id"
         :index=index
          :data="reply"> </reply>
    </div>
</template>

<script>
import Reply from './reply'
export default {
    props:['question'],
    data(){
        return{
            content:this.question.replies
        }
    },
    components:{Reply},
    created(){
        this.listen()
    },
    methods:{
        listen(){
            EventBus.$on('newReply',(reply) =>{
                this.content.unshift(reply)
            })

            EventBus.$on('deleteReply',(index)=>{
                //remove this reply totally from the DB too
                axios.delete(`/api/question/${this.question.slug}/reply/${this.content[index].id}`)
                //remove from the list
                     .then(res =>{
                         this.content.splice(index,1)
                     })

            })
        }
    }
}
</script>

<style>

</style>
