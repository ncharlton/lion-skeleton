<template>
    <div class="profile-form register-bar">
        <form enctype="multipart/form-data">
            <div class="form-group">
                <label for="hobbies">Tell us your hobbies</label>
                <input type="text" class="form-control form-control-sm" id="hobbies" name="hobbies" v-model="hobbies"/>
            </div>
            <div class="form-group">
                <label for="profession">Your Profession</label>
                <input type="text" class="form-control form-control-sm" id="profession" name="profession" v-model="profession"/>
            </div>
            <div class="form-group" style="margin-bottom: 30px;">
                <label for="avatar">Upload your profile picture</label>
                <input type="file" id="avatar" ref="file" v-on:change="checkImage()" accept="image/*"/>
            </div>
        </form>

        <button class="btn btn-primary register-btn" v-on:click="addProfile()">Add Profile</button>

        <!-- loading spinner -->
        <div class="spinner">
            <beat-loader :loading="loading" :color="color"></beat-loader>
        </div>
    </div>
</template>
<script>
import Axios from 'axios'
import auth from '../../auth'
import BeatLoader from 'vue-spinner/src/BeatLoader.vue'

export default {
    name: "profile-form",
    components: {BeatLoader},
    data() {
        return {
            image: "",
            hobbies: "",
            profession: "",
            loading: false,
            color: "#4486ce",
        }
    },
    methods: {
        checkImage() {
            this.image = this.$refs.file.files[0]
        },

        addProfile() {
            this.loading = true
            let formData = new FormData()

            formData.append("image", this.image)
            formData.append("actorId", auth.user.actor.id)
            formData.append("hobbies", this.hobbies)
            formData.append("profession", this.profession)

            console.log(formData);

            Axios.post("http://localhost:8000/api/profile",
                formData,
                {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                }
            )
            .then((result) => {
                console.log(result);

                this.$emit("finished", true)
                this.loading = false
            })
            .catch((error) => {
                console.log(error)
            })
        }
    }
}
</script>
<style>

</style>