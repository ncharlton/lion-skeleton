import Axios from 'axios'

const GLOBAL_URL = 'http://localhost:8000/';
const LOCAL_URL = 'http://localhost:8001/';

const INBOUND_SYNC_URL = 'sync/inbound/';
const OUTBOUND_SYNC_URL = 'sync/outbound/';

const G_I_SYNC_URL = GLOBAL_URL + INBOUND_SYNC_URL;
const G_O_SYNC_URL = GLOBAL_URL + OUTBOUND_SYNC_URL;

const L_I_SYNC_URL = LOCAL_URL + INBOUND_SYNC_URL;
const L_O_SYNC_URL = LOCAL_URL + OUTBOUND_SYNC_URL;

const G_O_SYNC_COMMENTS = G_I_SYNC_URL + 'comments';
const G_O_SYNC_COMMENTS_SINCE = G_O_SYNC_URL + 'comments/since';


const L_I_SYNC_COMMENTS_LAST = L_I_SYNC_URL + 'comments/last';
const L_I_SYNC_COMMENTS = L_I_SYNC_URL + 'comments';
const L_I_SYNC_COMMENTS_SINCE = L_O_SYNC_URL + 'comments/since';

export default {
    async fetchGlobalComments() {
        let result = await Axios.get(G_O_SYNC_COMMENTS);
        return result;
    },

    async syncComments(comments) {
        let result = await Axios.post(L_I_SYNC_COMMENTS, {
            comments: comments
        });
        return result;
    },

    async fetchGlobalCommentsSinceId(id) {
        let result = await Axios.get(G_O_SYNC_COMMENTS_SINCE, {
            params: {
                comment_id : id
            }
        });
        return result;
    },

    async syncCommentsToGlobal(id, comments) {
        let result = await Axios.post(G_O_SYNC_COMMENTS, {
            id: id,
            comments: comments
        })

        return result;
    },

    async fetchLocalCommentsSinceId(id) {
        let result = await Axios.get(L)
    },

    async fetchLatestCommentSync() {
        let result = await Axios.get(L_I_SYNC_COMMENTS_LAST);
        return result;
    }
}