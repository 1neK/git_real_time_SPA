<template>

</template>

<script>
    import User from "../../Helpers/User";

    export default {
        created() {

            User.logout();
            EventBus.$emit('logout');


        }
    }
</script>

<style>

</style>
