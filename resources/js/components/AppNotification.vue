<template>
    <div class="text-xs-center">
    <v-menu offset-y>
            <v-btn icon slot="activator">
                <v-icon :color="color"> notifications </v-icon> {{unreadCount}}
            </v-btn>
      <v-list class="noti">
        <v-list-title class="notif">Notifications</v-list-title>
        <v-divider></v-divider>
        <v-list-tile v-for="item in unread" :key="item.id">

                <v-list-tile-title @click="readIt(item)">{{item.text}}</v-list-tile-title>

        </v-list-tile>
        <v-divider></v-divider>
        <v-list-tile v-for="item in read" :key="item.id">
            <v-list-tile-title>{{item.text}}</v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-menu>
  </div>
</template>

<script>
export default {
    data(){
        return{
            read:{},
            unread:{},
            unreadCount:0,
            sound: "https://www.redringtones.com/wp-content/uploads/2016/09/twitter-notification-sound.mp3"
        }
    },
    created(){
        if(User.loggedIn()){
            this.getNotifications()
        }

        // Echo.private('App.User.' + User.id())
        //         .notification((notification) => {
        //             this.playSound()
        //             this.unread.unshift(notification)
        //             this.unreadCount++
        //         });
    },
    methods:{
        playSound(){
            let alert = new Audio(this.sound)
            alert.play()
        },
        getNotifications(){
            axios.post('/api/notifications')
                .then(res => {
                    this.read = res.data.read
                    this.unread = res.data.unread
                    this.unreadCount = res.data.unread.length
                })
                .catch(error => Exception.handle(error))
        },
        readIt(notification){
            axios.post('/api/markAsRead',{id:notification.id})
            .then(res => {
                this.unread.splice(notification,1)

                this.getNotifications()
                window.location=notification.link

            })
        }
    },
    computed:{
        color(){
            return this.unreadCount > 0 ? 'red' : 'red lighten-4'
        }
    }
    ,mounted() {

        Echo.channel('comment-channel')
            .listen('.CommentEvent', (message) => {



                let count = this.unreadCount;

                this.getNotifications();

                if (count != this.unreadCount )               this.playSound();


            });

    },
}
</script>

<style>
.noti{
    color:cornflowerblue;
    display: block;
    padding: 6px 30px 5px 12px;
    position:relative;
    cursor: pointer;
    text-decoration: none;
    padding-right: 30px;
    border: 1px solid rgba(100, 100, 100, .4);
    box-shadow: 0 3px 8px rgba(0, 0, 0, .25);
    border-radius: 0 0 2px 2px;
    top: 3px;
    width: 430px;
    z-index: -1;
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
</style>

