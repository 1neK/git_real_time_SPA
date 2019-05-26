<template>
<v-container>
    <v-list class="noti1">
        <v-list-tile class="notif2">Notifications</v-list-tile>
        <v-divider></v-divider>
        <v-list-tile-content v-for="item in unread" :key="item.id" class="noti">

                <v-list-tile-title @click="readIt(item)">{{item.text}}</v-list-tile-title>

        </v-list-tile-content>
        <v-divider></v-divider>
        <v-list-tile-content v-for="item in read" :key="item.id" class="notif">
            <v-list-tile-title @click="readIt(item)">{{item.text}}</v-list-tile-title>
        </v-list-tile-content>
    </v-list>
</v-container>
</template>

<script>
export default {
    data(){
        return{
            read:[],
            unread:[],

        }
    },

    created() {
        axios.get('/api/all_notifications')
             .then(res => {
                    this.read = res.data.read
                    this.unread = res.data.unread
                    });
    },
    methods:{
        readIt(notification){
            axios.post('/api/markAsRead',{id:notification.id})
            .then(res => {
                window.location=notification.link

            })
        }
    }
}
</script>

<style>
.noti{
    background-color:  grey lighten-5;
    color: rgb(38, 96, 116);
    outline:none;
    font-size: 13px;
    font-weight: bold;
    margin: 0;
    padding: 0;
    display: block;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
}
.notif{
    background-color: grey lighten-5;
    color: #333;
    outline:none;
    font-size: 13px;
    font-weight: bold;
    margin: 0;
    padding: 0;
    display: block;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;

}
.noti1{
    color:cornflowerblue;
    display: block;
    padding: 6px 30px 5px 12px;
    position:relative;
    cursor: pointer;
    text-decoration: none;
    padding-right: 30px;

    top: 3px;
}
.notif2{
    background-color: grey lighten-5;
    color: #333;
    outline:none;
    font-size: 20px;
    font-weight: bold;
    margin: 0;
    padding: 0;
    display: block;
    margin-block-start: 1em;
    margin-block-end: 1em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
}

</style>
