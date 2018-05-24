import Axios from 'axios'

const API_URL = 'http://localhost:8001/api/'
const API_COMMENTS_URL = API_URL + 'comments'
const API_NEW_COMMENT_URL = API_URL + 'comment/new'

export default {
    verifyResult(result) {
        if(result.status == '200')
            return true;
        else
            return false;
    },

    async fetchComments() {
        let result = await Axios.get(API_COMMENTS_URL);

        return result;
    },

    async comment(comment, user_id) {
        let result = await  Axios.post(API_NEW_COMMENT_URL, {
            comment: comment,
            user_id: user_id
        });

        return result;
    },
}