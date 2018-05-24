import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import VueSession from 'vue-session'
import Vuelidate from 'vuelidate';
import Moment from 'moment'
import Bootstrap from 'bootstrap'
import popper from 'popper.js'
import auth from './auth'



import Register from './components/forms/RegisterForm.vue'
import Home from './components/Home.vue'
import Login from './components/forms/LoginForm.vue'
import Dashboard from './components/Dashboard.vue'
import HumanForm from './components/forms/HumanForm.vue'
import CompleteRegistration from './components/actions/CompleteRegistration.vue'

import SyncComments from './components/sync/SyncComments.vue'

const api = "http://localhost:8000/api/";


Vue.config.productionTip = false
Vue.prototype.Auth = auth

const routes = [
    { path: '*' , redirect: "/"},
    { path: '/' , component: Home },
    { path: '/sync', component: SyncComments},
    { path: '/login', component: Login},
    { path: '/register', component: Register },
    { path: '/dashboard', component: Dashboard},
    { path: '/human/new', component: HumanForm},
    { path: '/register/complete', component: CompleteRegistration}
]


export const router = new VueRouter({
    routes,
    //mode: 'history',
})


Vue.use(VueRouter)
Vue.use(Vuelidate)

Vue.filter('formatDate', function (value) {
    if (value) {
        return Moment(String(value)).format('MMMM Do YYYY, h:mm:ss a')
    }
})

new Vue({
    router,
    render: h => h(App)
}).$mount('#app')
