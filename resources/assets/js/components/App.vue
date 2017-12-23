<template><div>

<nav class="navbar navbar-default">
    <div class="container"><div class="row">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand font-cursive" href="#">RateSpotifyMusic</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <p class="navbar-text navbar-right">Zalogowano jako <a href="#" class="navbar-link">{{ me.display_name }}</a></p>

            <ul class="navbar navbar-right">
                <li>
                    <a href="#">Ranking</a>
                    <a href="#">Twoje oceny</a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div></div><!-- /.container-fluid -->
</nav>


    <router-view    :accessToken="accessToken"
                    :userId="me.id">

    </router-view>

</div></template>

<script>
export default {
    data: function () {
        return {
            accessToken: "Requesting token...",
            me: {
                display_name: ""
            },
            error: ""
        }
    }, 
    mounted() {
        this.getToken();
    },

    methods: {
        getToken(){
            axios.get('/session').then((response) => {
                this.accessToken = "Bearer " +  response.data.accessToken

                this.getMe();
            });
        },
        getMe() { 
            const url = 'https://api.spotify.com/v1/me';
            var instance = axios.create();
            instance.defaults.headers.common = {};
            instance.get(url, {
                headers : {
                    'Authorization' : this.accessToken
                }
            }).then((response) => {
                this.me = response.data
                if(this.me.display_name == null){
                    this.me.display_name = this.me.id
                }
            }).catch(function (error) {
                if (401 === error.response.status) {
                    window.location.replace("/auth");
                }
            });
        },

    }
}
</script>
