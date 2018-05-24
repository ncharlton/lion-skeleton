import {router} from '../main'
import Axios from 'axios'

const API_URL = 'http://localhost:8000/api/'
const LOGIN_URL = API_URL + 'login'
const CHECK_URL = LOGIN_URL + "/check"
const REGISTER_URL = API_URL +  "user"

export default {
    user: {
        id: null,
        actor: {
            id: ""
        },
        username: "",
        email : "",
        authenticated: false,
        token: "",
        complete: "",
    },

    /**
     * Logs in user in backend. Backend returns access token
     *
     * @param username
     * @param password
     * @returns {Promise}
     */
    async login(username, password) {
        let result = await Axios.get(LOGIN_URL, {
            params: {
                "username" : username,
                "password" : password
            },
        })

        return result
    },


    /**
     * Fetches User object with access token and stores user in local storage
     * => user is now logged in
     *
     * @param token
     * @param redirect
     */
    check(token, redirect) {
        Axios.get(CHECK_URL, {
            params: {
                "token" : token
            }
        })
        .then((response) => {
            this.user.id = response.data.id
            this.user.actor.id = response.data.actor.id
            this.user.username = response.data.username
            this.user.email = response.data.email
            this.user.authenticated = true
            this.user.token = token
            this.user.complete = response.data.complete

            localStorage.setItem("user", JSON.stringify(this.user))

            if(redirect) {
                router.replace(redirect)
            }

            // check if user has completed his registration
            this.checkComplete()
        })
        .catch((error) => {

        })
    },

    /**
     * Registers user
     *
     * @param username
     * @param email
     * @param password
     * @param firstName
     * @param lastName
     * @returns {Promise<any>}
     */
    async register(username, email, password, firstName, lastName) {
        let result = await Axios.post(REGISTER_URL, {
            username: username,
            email: email,
            password: password,
            firstName: firstName,
            lastName: lastName
        })

        return result
    },

    /**
     * Checks if user is exists in local storage
     */
    checkAuth() {
        let jwt = JSON.parse(localStorage.getItem('user'))

        if(jwt) {
            this.user.id = jwt.id
            this.user.actor.id = jwt.actor.id
            this.user.authenticated = true
            this.user.username = jwt.username
            this.user.token = jwt.token
            this.user.email = jwt.email

            this.user.complete = jwt.complete
        } else {
            this.user.authenticated = false
        }
    },

    /**
     * Checks if user exists and is logged in.
     * @returns {boolean}
     */
    isLogged() {
        if(this.user) {
            return this.user.authenticated
        } else {
            return false;
        }
    },

    /**
     * Saves user to local storage.
     * Use when new information has to be stored locally.
     */
    flush() {
        localStorage.setItem("user", JSON.stringify(this.user))
    },

    /**
     * Check if registration has been completed
     */
    checkComplete() {
        if(this.isLogged()) {
            if(this.user.complete < "5") {
                router.replace("/register/complete")
            }
        }
    },

    /**
     * Deletes local user object and loggs user out.
     */
    logout() {
        localStorage.removeItem('user')
        this.user.authenticated = false
        router.replace("/")
    }
}