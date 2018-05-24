<template>
    <div>
        <navigation></navigation>

        <router-view></router-view>

    </div>
</template>

<script>
import Navigation from './components/main/Navigation.vue'
import Comment from './components/Comment.vue'
import auth from './auth'
import router from './main'

export default {
    name: 'app',
    components: {
        Navigation,
        Comment,
    },
    data() {
        return {
            user : auth.user,
            auth : auth
        }
    },
    created() {
        auth.checkAuth()
        auth.checkComplete()
    }
}

</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
