<template>
    <div class="address-form register-bar">
        <div class="form-group">
            <div class="form-row">
                <div class="col-9">
                    <label for="streetName">Street name</label>
                    <input id="streetName" class="form-control form-control-sm" name="firstName" type="text"  v-model="streetName" />
                </div>
                <div class="col-3">
                    <label for="streetNumber">Number</label>
                    <input id="streetNumber" class="form-control form-control-sm" name="surName" type="text"  v-model="streetNumber" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="country">Select country</label>
            <multiselect id="country" v-model="country" :options="countries" placeholder="Pick a value"></multiselect>
        </div>
        <div class="form-group">
            <label for="county">County</label>
            <input id="county" class="form-control form-control-sm" name="otherNames" type="text"  v-model="county" />
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-9">
                    <label for="city">City</label>
                    <input id="city" class="form-control form-control-sm" name="firstName" type="text"  v-model="city" />
                </div>
                <div class="col-3">
                    <label for="postalCode">ZIP</label>
                    <input id="postalCode" class="form-control form-control-sm" name="surName" type="text"  v-model="postalCode" />
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-5">
                    <label for="phoneType">Type</label>
                    <select class="form-control form-control-sm" id="phoneType" name="phoneType" v-model="phoneType">
                        <option v-for="type in types">{{ type }}</option>
                    </select>
                </div>
                <div class="col-7">
                    <label for="phoneNumber">Phone number</label>
                    <input id="phoneNumber" class="form-control form-control-sm" name="phoneNumber" type="text" v-model="phoneNumber" />
                </div>
            </div>
        </div>
        <button class="btn btn-primary register-btn" v-on:click="addAddress()" >Add Details</button>

        <!-- loading spinner -->
        <div class="spinner">
            <beat-loader :loading="loading" :color="color"></beat-loader>
        </div>
    </div>
</template>

<script>
import Axios from 'axios'
import auth from '../../auth/index'
import Multiselect from "vue-multiselect"
import Countries from "../../static/countries"
import Phones from "../../static/phones"
import BeatLoader from "vue-spinner/src/BeatLoader.vue"

export default {
    name: "address-form",
    props: [],
    components: {Multiselect, BeatLoader},
    data() {
        return {
            streetName: "",
            streetNumber: "",
            country: "",
            county: "",
            city: "",
            postalCode: "",
            phoneType: "",
            phoneNumber: "",

            // general
            countries: Countries.countries,
            types: Phones.phoneTypes,
            loading: false,
            color: "#4486ce",
        }
    },
    methods: {
        addAddress() {
            this.loading = true
            Axios.post("http://localhost:8000/api/address", {
                actorId : auth.user.actor.id,
                street: this.streetName,
                streetNumber: this.streetNumber,
                country: this.country,
                county: this.county,
                city: this.city,
                postalCode: this.postalCode,
                phoneType: this.phoneType,
                phoneNumber: this.phoneNumber,
            })
            .then((result) => {
                this.$emit("finished", true)
                this.loading = false
            })
            .catch((error) => {

            })
        }
    },
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>

</style>