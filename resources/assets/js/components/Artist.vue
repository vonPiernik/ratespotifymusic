<template>
    <div>
        <div class="container">
            <div v-if="artist.id" class="artist">
                <div class="warning" v-if="this.warning.show">
                    {{ this.warning.msg }}
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="artist__cover">

                            <img :src="artist.images[0].url" class="artist__cover__img">
                        </div>
                    </div>

                    <div class="col-md-7">
                        
                        <h1 class="artist__name" v-bind:style="{ color: colors.first }">{{ artist.name }}</h1>
                        <h5 class="artist__genres"><span v-for="genre in artist.genres">{{ genre }} </span></h5>

                        <div class="artist__albums">
                            <h2 class="artist__albums__title">Albumy</h2>
                            <div class="col-md-4 artist__albums__album" v-for="album in artist.albums.items" v-if="album.album_type == 'album'"><router-link :to="'/album/' + album.id">
                                <img :src="album.images[0].url" :alt="album.name">
                                <span class="artist__albums__album__album-name">{{ album.name }}</span>
                            </router-link></div>
                        </div>

                        <div class="artist__albums">
                            <h2 class="artist__albums__title">Single</h2>
                            <div class="col-md-4 artist__albums__album" v-for="album in artist.albums.items" v-if="album.album_type == 'single'">
                                <img :src="album.images[0].url" :alt="album.name">
                                <span class="artist__albums__album__album-name">{{ album.name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['accessToken', 'accessTokenFull', 'userId'],
    data: function () {
        return {
            artist: {},
            render: true,
            colors: {
                first: "",
                second: ""
            },
            devices: {},
            activeDevice: {},
            deviceRunningButNotActive: {},
            warning: {
                show: false,
                msg: ""
            }
        }
    }, 
    mounted() {
        if(this.userId){
            this.getArtist();
        }
    },
    watch: {
        userId: function () {
            if(this.userId){
                this.getArtist();
            }
        },
        $route: function() {
            if(this.userId){
                this.getArtist();
            }
        }
    },
    methods: {
        getArtist() { 
            const url = '/api/spotify/artist/' + this.$route.params.id;
            var instance = axios.create();
            instance.defaults.headers.common = {};
            instance.get(url, {
                headers : {
                    'Authorization' : this.accessToken,
                    'User' : this.userId
                }
            }).then((response) => {
                this.artist = response.data
                this.artist.albums.items = _.uniqBy(this.artist.albums.items, 'name')
                this.render = false
                this.$nextTick(() => {
                    this.render = true
                })

                Vibrant.from(this.artist.images[0].url).getPalette()
                    .then((palette) => {
                        this.colors.first = "rgb(" + palette.Muted._rgb.toString() + ")"
                        this.colors.second = "rgb(" + palette.Vibrant._rgb.toString() + ")"
                        this.$emit('setColors', this.colors)
                    })

                $(document).ready(function(){
                    $('.checked').prop('checked', true);
                    $("input").not(".checked").prop('checked', false);
                })

            });
        },
        
    }
}
</script>
