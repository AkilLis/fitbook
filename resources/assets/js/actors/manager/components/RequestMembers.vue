<template>
    <div class="row">
        <div class="small-12 columns content--search">
             <input type="text" name="search" class="" placeholder="search ...">
        </div>
    </div>

    <form>
        <ul class="row">
            <li class="small-12 member--list" v-for="request in requests">
                    <img v-bind:src="request.avatar_url" height="40" width="40" />
                    <span>{{request.first_name}}</span>
                     {{request.last_name}}
                     {{request.pivot.created_at}}
                    <a @click="acceptRequest(request)" class="button success member--button"><i class="fa fa-plus"></i></a>
                    <a @click="rejectRequest(request)" class="button alert member--button"><i class="fa fa-times"></i></a>
            </li>
        </ul>
    </form>

</template>

<script>
    export default {
        
        props: { 
            id : {},
            type : {},
        },

        data() {
            return {
                requests : [],
                requestType : 0,
            }
        },

        created : function () {
            this.init();
        },

        ready : function () {
            
        },

        methods : {
            init: function () {
                this.$http.get(this.$env.get('APP_URI') + 'api/club/edit/' + this.id + '/request?memberType=' + this.type).then((response) => 
                {
                    this.requests = response.data;
                }, (response) => {

                }); 
            },

            acceptRequest : function ($request) {
                this.$http.put(this.$env.get('APP_URI') + 'api/club/edit/' + this.id + '/request/' + $request.id, {
                        'roleType': $request.pivot.type, 
                        'requestType': 'Accepted' 
                    }).then((response) => 
                {
                    this.$dispatch('accept-request', $request);
                    this.requests.$remove($request);
                }, (response) => {

                }); 
            },

            rejectRequest : function ($request) {
                this.$http.put(this.$env.get('APP_URI') + 'api/club/edit/' + this.id + '/request/' + $request.id, {
                        'roleType': $request.pivot.type, 
                        'requestType': 'Rejected' 
                    }).then((response) => 
                {
                    this.$dispatch('reject-request', $request);
                    this.requests.$remove($request);
                }, (response) => {

                }); 
            },  
        },

        watch : {
            type : function(val, oldVal) {
                this.init();
            }
        },
    }
</script>
