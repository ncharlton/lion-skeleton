<template>
    <div>
        <div v-if="!Auth.isLogged()">
            Not logged in
        </div>
        <div v-if="Auth.isLogged()">
            {{ Auth.user.username }}
            HURRA
        </div>
    </div>
</template>
<script>


export default {
    name: "home",
    components: {

    },
    data() {
        return {

        }
    },
}
</script>
<style>

</style>