<template>
    <div>
        <div class="container register-complete">
            <h1>Complete your registration</h1>
            <div class="row steps">
                <div class="col-4 step" :class="{ working : stepOneWorking , complete : stepOneComplete }">
                    <p class="step-title">Step 1</p>
                    <p class="step-description">Your Details</p>
                </div>
                <div class="col-4 step" :class="{ working : stepTwoWorking , complete : stepTwoComplete }">
                    <p class="step-title">Step 2</p>
                    <p class="step-description">Your Address</p>
                </div>
                <div class="col-4 step" :class="{ working : stepThreeWorking , complete : stepThreeComplete }">
                    <p class="step-title">Step 3</p>
                    <p class="step-description">Your Profile</p>
                </div>
            </div>
        </div>
        <human-form @finished="humanFinished()" v-if="stepOneWorking"></human-form>
        <address-form @finished="addressFinished()" v-if="stepTwoWorking"></address-form>
        <profile-form @finished="profileFinished()" v-if="stepThreeWorking"></profile-form>

    </div>
</template>

<script>
    import HumanForm from "../forms/HumanForm.vue"
    import AddressForm from "../forms/AddressForm.vue"
    import ProfileForm from "../forms/ProfileForm.vue"
    import auth from "../../auth"
    import {router} from "../../main"

    export default {
        name: "register-complete",
        components: {
            ProfileForm,
            HumanForm, AddressForm},
        data() {
            return {
                user: auth.user,
                stepOneWorking: false,
                stepTwoWorking: false,
                stepThreeWorking: true,
                stepOneComplete: false,
                stepTwoComplete: false,
                stepThreeComplete: false,
            }
        },
        beforeMount() {
            this.stepStatus()
            console.log(auth.user)
        },
        methods: {
            stepStatus() {
                if(auth.user.complete === "0") {
                    this.stepOneWorking = true
                    this.stepThreeWorking = false
                }
                if(auth.user.complete === "1") {
                    this.stepOneComplete = true
                    this.stepTwoWorking = true
                }
                if(auth.user.complete === "2") {
                    this.stepOneComplete = true
                    this.stepTwoComplete = true
                    this.stepThreeWorking = true
                }
            },

            humanFinished() {
                this.stepOneWorking = false
                this.stepOneComplete = true
                this.stepTwoWorking = true
                auth.user.complete = 1
                auth.flush()
            },

            addressFinished() {
                this.stepTwoWorking = false
                this.stepTwoComplete = true
                this.stepThreeWorking = true
                auth.user.complete = 2
                auth.flush()
            },

            profileFinished() {
                this.stepThreeWorking = false
                this.stepThreeComplete = true
                auth.user.complete = 5
                auth.flush()

                // redirect to dashboard
                router.replace("/")
            }
        }
    }
</script>

<style>

</style>