<template>
    <div class="login-bar">
        <div class="form-group">
            <label for="InputUsername">Username</label>
            <input type="text" class="form-control" id="InputUsername" name="username" placeholder="Username" v-model.trim="username" @input="$v.username.$touch()">
        </div>

        <div class="form-group">
            <label for="InputPassword">Password</label>
            <input type="password" class="form-control" id="InputPassword" placeholder="Password" v-model.trim="password" @input="$v.password.$touch()">
        </div>

        <button class="btn btn-primary register-btn" v-on:click="login()" :disabled="$v.$invalid">Login</button>

        <!-- loading spinner -->
        <div class="spinner">
            <beat-loader :loading="loading" :color="color"></beat-loader>
        </div>

        <!-- error message -->
        <div class="alert alert-danger" role="alert" v-if="error">
            {{ errorMessage }}
        </div>

    </div>
</template>
<script>
    import auth from '../../auth/index'
    import BeatLoader from 'vue-spinner/src/BeatLoader.vue'
    import { required, minLength } from 'vuelidate/lib/validators'

    export default {
        name: "login",
        components: {BeatLoader},
        data() {
            return {
                username: "",
                password: "",
                loading: false,
                color: "#4486ce",
                error: false,
                errorMessage: "",
            }
        },
        validations: {
            username: {
                required,
                minLength: minLength(4)
            },
            password: {
                required,
                minLength: minLength(6)
            },
        },
        methods: {
            login() {
                this.error = false;
                this.loading = true
                auth.login(this.username, this.password)
                    .then((result) => {
                        auth.check(result.data.token, '/')
                    })
                    .catch((error) => {
                        this.loading = false
                        this.error = true;
                        this.errorMessage = error.response.data.message
                    })
            }
        }
    }
</script>
<style>

</style>