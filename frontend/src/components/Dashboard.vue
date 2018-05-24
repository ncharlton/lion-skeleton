<template>
    <div>
        Logged in as:
        [{{user.username}}] - {{ user.token }}
    </div>
</template>

<script>
    import auth from '../auth'
    import {router} from '../main'

    export default {
        name: "dashboard",
        data() {
            return {
                user : auth.user
            }
        },
        created() {
            if(!auth.isLogged()) {
                router.replace("/login")
            }
        },
        methods: {

        },
        route: {
            canActivate() {
                return auth.user.authenticated
            }
        }
    }
</script>

<style>

</style>