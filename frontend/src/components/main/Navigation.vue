<template>
    <header class="container-fluid top-bar">
        <div class="logo"><router-link to="/">lionapp</router-link></div>
        <ul class="nav justify-content-end top-nav">
            <li class="nav-item" v-if="!user.authenticated">
                <router-link to="/register">Register</router-link>
            </li>
            <li class="nav-item">
                <router-link to="/login" v-if="!user.authenticated">Login</router-link>
            </li>

            <li class="nav-item">
                <a href="#" v-if="user.authenticated" v-on:click="auth.logout()">Logout</a>
            </li>

        </ul>
    </header>
</template>

<script>
    import auth from "../../auth"

    export default {
        name: "navigation",
        data() {
            return {
                user : auth.user,
                auth: auth
            }
        },
        method: {
            logout() {
                auth.logout()
            },
            test() {
                alert(true)
            }
        }
    }
</script>

<style>

</style>