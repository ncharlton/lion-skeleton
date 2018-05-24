<template>
    <div class="register-bar" :class="{success : action }">
        <div class="register-form" :class="{hide :  action}">
            <div class="form-group">
                <label for="InputUsername">Username</label>
                <input type="text" class="form-control" id="InputUsername" name="username" placeholder="Username" v-model.trim="username" @input="$v.username.$touch()">
                <div class="valid-feedback show" v-if="$v.username.minLength && $v.username.required">
                    Looks good!
                </div>
                <div class="invalid-feedback show" v-if="!$v.username.required">
                    Please choose a username.
                </div>
                <div class="invalid-feedback show" v-if="!$v.username.minLength">Username must have at least {{$v.username.$params.minLength.min}} letters.</div>
            </div>

            <div class="form-group">
                <label for="InputEmail">Email address</label>
                <input type="email" class="form-control" id="InputEmail"  placeholder="Enter email" v-model.trim="email" @input="$v.email.$touch()">
                <div class="valid-feedback show" v-if="$v.email.required && $v.email.email">
                    Looks good!
                </div>
                <div class="invalid-feedback show" v-if="!$v.email.required">
                    Please enter an email
                </div>
                <div class="invalid-feedback show" v-if="!$v.email.email">
                    Please enter a valid email
                </div>
            </div>

            <div class="form-group">
                <label for="InputPassword">Password</label>
                <input type="password" class="form-control" id="InputPassword" placeholder="Password" v-model.trim="password" @input="$v.password.$touch()">
                <div class="valid-feedback show" v-if="$v.password.minLength && $v.password.required">
                    Looks good!
                </div>
                <div class="invalid-feedback show" v-if="!$v.password.required">
                    Please choose a password
                </div>
                <div class="invalid-feedback show" v-if="!$v.password.minLength">Password must have at least {{ $v.password.$params.minLength.min }} letters</div>
            </div>

            <div class="form-group">
                <label for="InputPasswordRepeat">Repeat password</label>
                <input type="password" class="form-control" id="InputPasswordRepeat" placeholder="Repeat password" v-model.trim="passwordRepeat" @input="$v.passwordRepeat.$touch()">
                <div class="valid-feedback show" v-if="$v.passwordRepeat.sameAsPassword && $v.passwordRepeat.length > 1">
                    Looks good! Your passwords match!
                </div>
                <div class="invalid-feedback show" v-if="!$v.passwordRepeat.sameAsPassword">
                    Your passwords don't match
                </div>
            </div>

            <hr>

            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control form-control-sm" placeholder="First name" v-model.trim="firstName">
                </div>
                <div class="col">
                    <input type="text" class="form-control form-control-sm" placeholder="Last name" v-model.trim="lastName">
                </div>
            </div>

            <br>
            <button class="btn btn-primary register-btn" v-on:click="register()" :disabled="$v.$invalid">Register</button>

            <!-- loading spinner -->
            <div class="spinner">
                <beat-loader :loading="loading" :color="color"></beat-loader>
            </div>

            <!-- error message -->
            <div class="alert alert-danger" role="alert" v-if="error">
                {{ errorMessage }}
            </div>
        </div>

        <!-- register success message -->
        <div class="register-success" :class="{show :  action}">
            <h3>Successfully registered!</h3>
        </div>
        <div class="register-redirect" :class="{show :  action}">
            <p><strong>My friend!</strong> Your being redirect now...</p>
        </div>
    </div>
</template>
<script>
import auth from '../../auth/index'
import Axios from 'axios'
import BeatLoader from 'vue-spinner/src/BeatLoader.vue'
import { required, email, minLength, sameAs } from 'vuelidate/lib/validators'


export default {
    name: "register",
    components: {BeatLoader},
    data() {
        return {
            errors: [],
            username: "",
            email: "",
            password: "",
            passwordRepeat: "",
            firstName: "",
            lastName: "",
            action: false,
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
        email: {
            required,
            email
        },
        password: {
            required,
            minLength: minLength(6)
        },
        passwordRepeat: {
            required,
            sameAsPassword: sameAs('password')
        },
    },
    methods: {
        register() {

            this.loading = true
            // register user and wait for result
            auth.register(this.username, this.email, this.password, this.firstName, this.lastName)
                .then((result) => {
                    this.action = true
                    this.loading = false

                    // when registered -> login user -> redirect to dashboard
                    auth.login(this.username, this.password)
                        .then((result) => {
                            auth.check(result.data.token, '/dashboard')
                        })
                })
                .catch((error) => {
                    this.loading = false;
                    this.error = true
                    let response = error.response.data;

                   this.errorMessage = response[1].message;

                })
        }
    }
}
</script>
<style>

</style>