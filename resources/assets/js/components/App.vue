<template><div>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container"><div class="row">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <router-link class="navbar-brand font-cursive" to="/">RateSpotifyMusic</router-link>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <p class="navbar-text navbar-right">Zalogowano jako <a href="#" class="navbar-link">{{ me.display_name }}</a></p>

            <ul class="navbar navbar-right">
                <li>
                    <a href="#">Ranking</a>
                    <a href="#">Twoje oceny</a>
                    <router-link to="/album">Album</router-link>
                    <router-link to="/artist">Artysta</router-link>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div></div><!-- /.container-fluid -->
</nav>

    <div class="searchBox" v-bind:style="{ background: 'linear-gradient(to right,' + colors.first + ','+ colors.second + ')' }">
        <input type="text" placeholder="Szukaj utworu lub albumu..." v-model="keywords" v-on:focus="showSearchBox"><span class="search fa fa-search"></span>
        <ul class="searchSuggest" v-click-outside="hideSearchBox">
            <div class="li-wrapper li-wrapper--artists" v-if="result.artists.items.length > 0">
            <span class="searchSuggest__label">Artyści</span>
                <li v-for="item in result.artists.items">
                    <div class="searchSuggest__albumCoverWrapper"><img v-if="item.images.length > 0" :src="item.images[1].url" class="searchSuggest__albumCover"></div>
                    {{ item.name }} 
                </li>
            </div>
            <div class="li-wrapper li-wrapper--tracks" v-if="result.tracks.items.length > 0">
            <span class="searchSuggest__label">Utwory</span>
                <li v-for="item in result.tracks.items">
                     <router-link :to="'/album/' + item.album.id">{{ item.name }} <small>( <span v-for="artist in item.artists">{{ artist.name }} </span>)</small>

                    <span class="searchSuggets__rating" v-if="item.avgRating">{{ item.avgRating }} / 10</span>
                    </router-link>
                </li>
            </div>
            <div class="li-wrapper li-wrapper--albums" v-if="result.albums.items.length > 0">
            <span class="searchSuggest__label">Albumy</span>
               <li v-for="item in result.albums.items"><router-link :to="'/album/' + item.id"> 
                    <div class="searchSuggest__albumCoverWrapper"><img v-if="item.images.length > 0" :src="item.images[1].url" class="searchSuggest__albumCover"></div>
                    {{ item.name }} 
                </router-link></li>
            </div>
        </ul>
    </div>

    <router-view    :accessToken="accessToken"
                    :userId="me.id"
                    @setColors="setColors">

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
            error: "",
            keywords: "",
            result: {
                artists: {
                    items: []
                },
                tracks: {
                    items: []
                },
                albums: {
                    items: []
                }
            },
            colors: {
                first: "",
                second: ""
            }
        }
    }, 
    mounted() {
        this.getToken();
    },

    watch: {
        keywords: {
            handler: function(after, before) {
                if(this.keywords.length > 2){
                    this.search()
                } else {
                    $("ul.searchSuggest").fadeOut();
                }
            }
        },
        $route (to, from) {
            this.hideSearchBox()
        }
    },
    methods: {
        getToken(){
            axios.get('/session').then((response) => {
                this.accessTokenFull = "Bearer " +  response.data.accessToken
                this.accessToken = response.data.accessToken

                this.getMe();
            });
        },
        getMe() { 
            const url = 'https://api.spotify.com/v1/me';
            var instance = axios.create();
            instance.defaults.headers.common = {};
            instance.get(url, {
                headers : {
                    'Authorization' : this.accessTokenFull
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
        search: _.debounce (
            function() {
                const url = '/api/spotify/search?limit=5&keywords=' + this.keywords;
                var instance = axios.create();
                instance.defaults.headers.common = {};
                instance.get(url, {
                    headers : {
                        'Authorization' : this.accessToken
                    }
                }).then((response) => {
                    this.result = response.data
                    $("ul.searchSuggest").fadeIn();
                });
            }
        ,250),
        hideSearchBox() {
            if(!$(".searchBox > input").is(":focus")){
                $("ul.searchSuggest").hide();
            }
        },
        showSearchBox() {
            $("ul.searchSuggest").show();
        },
        setColors(colors){
            this.colors.first = colors.first;
            this.colors.second = colors.second;
        }

    },
    directives: {
        'click-outside': {
            bind: function(el, binding, vNode) {
                // Provided expression must evaluate to a function.
                if (typeof binding.value !== 'function') {
                    const compName = vNode.context.name
                    let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`
                    if (compName) {
                        warn += `Found in component '${compName}'`
                    }

                    console.warn(warn)
                }
                // Define Handler and cache it on the element
                const bubble = binding.modifiers.bubble
                const handler = (e) => {
                    if (bubble || (!el.contains(e.target) && el !== e.target)) {
                        binding.value(e)
                    }
                }
                el.__vueClickOutside__ = handler

                // add Event Listeners
                document.addEventListener('click', handler)
            },

            unbind: function(el, binding) {
                // Remove Event Listeners
                document.removeEventListener('click', el.__vueClickOutside__)
                el.__vueClickOutside__ = null

            }
        }
    }
}
</script>
