<template>
    <div class="human-form register-bar">
        <div class="form-group">
            <div class="form-row">
                <div class="col">
                    <label for="firstName">First name</label>
                    <input id="firstName" class="form-control form-control-sm" name="firstName" type="text"  v-model.trim="firstName" />
                </div>
                <div class="col">
                    <label for="surName">Surname</label>
                    <input id="surName" class="form-control form-control-sm" name="surName" type="text"  v-model.trim="surName" />
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="otherNames">Other names</label>
            <input id="otherNames" class="form-control form-control-sm" name="otherNames" type="text"  v-model="otherNames" />
        </div>
        <div class="form-group">
            <label for="birthDate">Birth date</label>
            <datepicker id="birthDate" v-model="dateOfBirth"></datepicker>
        </div>
        <div class="form-group">
            <label for="placeOfBirth">Place of Birth</label>
            <input id="placeOfBirth" class="form-control form-control-sm" name="placeOfBirth" type="text"  v-model="placeOfBirth" />
        </div>
        <div class="form-row">
            <div class="col">
                <label>Married</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="married" value="false" checked v-model="married" >
                    <label class="form-check-label">
                        No
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="married" value="true" v-model="married">
                    <label class="form-check-label">
                        Yes
                    </label>
                </div>
            </div>
            <div class="col">
                <label>Gender</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" value="male" v-model="gender" checked>
                    <label class="form-check-label">
                        Male
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender"  value="female" v-model="gender">
                    <label class="form-check-label">
                        Female
                    </label>
                </div>
            </div>
        </div>
        <br>
        <button class="btn btn-primary register-btn" v-on:click="addHuman()" >Add Details</button>

        <!-- loading spinner -->
        <div class="spinner">
            <beat-loader :loading="loading" :color="color"></beat-loader>
        </div>
    </div>
</template>

<script>
import auth from "../../auth/index"
import Datepicker from 'vuejs-datepicker'
import BeatLoader from 'vue-spinner/src/BeatLoader.vue'
import Moment from 'moment'
import Axios from 'axios'

export default {
    name: "human-form",
    components: {Datepicker, BeatLoader},
    data() {
        return {
            firstName: "",
            surName: "",
            otherNames: "",
            married: null,
            gender: "",
            placeOfBirth: "",
            dateOfBirth: "",
            loading: false,
            color: "#4486ce",
        }
    },
    methods: {
        addHuman() {
            this.loading = true
            Axios.post("http://localhost:8000/api/human", {
                userId: auth.user.id,
                firstName: this.firstName,
                surName: this.surName,
                otherNames: this.otherNames,
                married: this.married,
                gender: this.gender,
                placeOfBirth: this.placeOfBirth,
                dateOfBirth: Moment(this.dateOfBirth).format('D.M.YYYY'),
            })
            .then((result) => {
                this.$emit('finished', true)
                this.loading = false
            })
            .catch((error) => {

            })
        }
    }
}
</script>

<style scoped>

</style>