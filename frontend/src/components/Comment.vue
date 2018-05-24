<template>
    <div>
        <textarea v-model="commentText"></textarea>
        <button v-on:click="comment()">Comment</button>
        <hr>
        <button v-on:click="loadComments()">Reload</button>
        <hr>
        <div v-if="comments" >
            <div v-for="comment in comments">
                {{ comment.comment_text }}
                <br>
                <i>written by <b>{{ comment.actor.user.user_name }}</b> at {{ comment.created_at | formatDate }}</i>
                <hr>
            </div>
        </div>
    </div>
</template>

<script>
    import auth from '../auth/index'
    import api from '../api/index'
    import Axios from 'axios'

    export default {
        name: "comment",
        components: {},
        data() {
            return {
                commentText : "",
                comments: [],
                commentsLoaded: false,
            }
        },
        mounted: function () {
            this.loadComments()
        },
        methods: {
            comment() {
                api.comment(this.commentText, auth.user.id)
                    .then((result) => {
                        if(api.verifyResult(result))
                            this.comments.unshift(result.data);
                        else
                            console.log(result);
                    })
            },

            loadComments() {
                api.fetchComments()
                    .then((result) => {
                        if(api.verifyResult(result))
                            this.comments = result.data;
                    })
            }
        }
    }

</script>

<style>

</style>