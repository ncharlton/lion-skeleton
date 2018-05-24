<template>
    <div>
        This is the database Syncer. This is a test syncing comments
        <hr>
        <button v-on:click="syncComments()">Sync Comments</button>
        <hr>
        <br>
            <div v-html="output"></div>


        <br>
        <hr>
    </div>
</template>
<script>
    import Syncer from '../../sync'

    export default {
        name: "syncComments",
        data() {
            return {
                output: "",
                globalComments: [],
            }
        },
        methods: {
            syncComments() {
                Syncer.fetchLatestCommentSync()
                    .then((result) => {
                        let id = result.data['sync']['id'];
                        let comments = result.data['sync']['comments'];

                        Syncer.syncCommentsToGlobal(id, comments)
                            .then((result) => {
                                this.globalComments = result.data;
                                this.output = "";
                                this.output += "Fetched " + this.globalComments.length + " comments from global database after last ID<br>";
                                this.output += "Starting to compare with local results: <br>";

                                Syncer.syncComments(this.globalComments)
                                    .then((result) => {
                                        let messages = "";
                                        result.data.forEach(function(message) {
                                            messages += "<i>" + message + "</i><br>";
                                        })

                                        if(result.data.length > 0) {
                                            this.output += "<br>" + messages;
                                        } else {
                                            this.output += "<br><b>Nothing to sync</b><br>";
                                        }


                                    });
                            });

                        /**Syncer.fetchGlobalCommentsSinceId(id)
                            .then((result => {
                                this.globalComments = result.data;
                                this.output = "";
                                this.output += "Fetched " + this.globalComments.length + " comments from global database after last ID<br>";
                                this.output += "Starting to compare with local results: <br>";


                                Syncer.syncComments(this.globalComments)
                                    .then((result) => {
                                        let messages = "";
                                        result.data.forEach(function(message) {
                                            messages += "<i>" + message + "</i><br>";
                                        })

                                        if(result.data.length > 0) {
                                            this.output += "<br>" + messages;
                                        } else {
                                            this.output += "<br><b>Nothing to sync</b><br>";
                                        }


                                    });
                            }))**/
                    });

                /*
                Syncer.fetchGlobalComments()
                    .then((result) => {
                        this.globalComments = result.data;
                        this.output = "";
                        this.output += "Fetched " + this.globalComments.length + " comments from global database<br>";
                        this.output += "Starting to compare with local results: <br>";


                        Syncer.syncComments(this.globalComments)
                            .then((result) => {
                                let messages = "";
                                result.data.forEach(function(message) {
                                    messages += "<i>" + message + "</i><br>";
                                })

                                if(result.data.length > 0) {
                                    this.output += "<br>" + messages;
                                } else {
                                    this.output += "<br><b>Nothing to sync</b><br>";
                                }


                            });
                    })
                    */
            }
        }
    }

</script>
<style>

</style>