<template>
    <div>
        <div class="container">
            <div v-if="album.type" class="album">
                <div class="warning" v-if="this.warning.show">
                    {{ this.warning.msg }}
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="album__cover">
                            <div class="album__rating">
                                <RatingStars v-if="render && album.album_type!='single'" :id="album.id" :userId="userId" :userRating="album.userRating" :roundAvgRating="album.roundAvgRating"></RatingStars>
                                <span class="single" v-if="album.album_type=='single'" v-bind:style="{ backgroundColor: colors.first }">Singiel</span>
                            </div>

                            <img :src="album.images[0].url" class="album__cover__img">
                        </div>
                        <p class="trackRating--score" v-if="album.avgRating && album.album_type!='single'">Średnia ocena albumu: <strong>{{ album.avgRating }} / 10</strong></p>
                        <p class="trackRating--score" v-if="album.tracks.items[0].avgRating && album.album_type=='single'">Średnia ocena singla: <strong>{{ album.tracks.items[0].avgRating }} / 10</strong></p>
                    </div>

                    <div class="col-md-7">
                        
                        <h1 class="album__name" v-bind:style="{ color: colors.first }">{{ album.name }}</h1>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Nazwa utworu</td>
                                        <td></td>
                                        <td colspan="2">Ocena</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="track in album.tracks.items">
                                        <td>{{ track.track_number }}</td>
                                        <td>{{ track.name }}</td>
                                        <td v-if="activeDevice || deviceRunningButNotActive">
                                            <a :href="'/#'+track.id" v-on:click="play(track, $event)" :id="'open-track-' + track.id">Odtwórz</a>
                                        </td>
                                        <td v-else>
                                            <a target="_BLANK" :href="track.external_urls.spotify" :id="'open-track-' + track.id" v-on:click="getDevices">Odtwórz</a>
                                        </td>
                                        <td>
                                            <RatingStars v-if="render && album.album_type!='single'" :id="track.id" :userId="userId" :userRating="track.userRating" :roundAvgRating="track.roundAvgRating"></RatingStars>
                                            <RatingStars v-if="render && album.album_type=='single'" :id="album.id" :userId="userId" :userRating="album.userRating" :roundAvgRating="album.roundAvgRating"></RatingStars>
                                        </td>
                                        <td>
                                            <span v-if="track.avgRating && album.album_type!='single'">{{ track.avgRating }} / 10</span>
                                            <span v-else-if="album.avgRating && album.album_type=='single'">{{ album.avgRating }} / 10</span>
                                            <span v-else>x / 10</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
            album: {},
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
            this.getAlbum();
        }
    },
    watch: {
        userId: function () {
            if(this.userId){
                this.getAlbum();
            }
        },
        $route: function() {
            if(this.userId){
                this.getAlbum();
            }
        }
    },
    methods: {
        getDevices(){
            const url = "https://api.spotify.com/v1/me/player/devices";
            var instance = axios.create();
            instance.defaults.headers.common = {};
            instance.get(url,{
                headers : {
                    'Authorization' : this.accessTokenFull
                }
            }).then((response) => {
                this.devices = response.data.devices
                this.activeDevice = _.find(response.data.devices, 'is_active');
                if(this.devices[0] && !this.activeDevice){
                    this.deviceRunningButNotActive = this.devices[0]
                }
            })
        },
        getAlbum() { 
            const url = '/api/spotify/album/' + this.$route.params.id;
            var instance = axios.create();
            instance.defaults.headers.common = {};
            instance.get(url, {
                headers : {
                    'Authorization' : this.accessToken,
                    'User' : this.userId
                }
            }).then((response) => {
                this.album = response.data
                this.render = false
                this.$nextTick(() => {
                    this.render = true
                })

                Vibrant.from(this.album.images[0].url).getPalette()
                    .then((palette) => {
                        this.colors.first = "rgb(" + palette.Muted._rgb.toString() + ")"
                        this.colors.second = "rgb(" + palette.Vibrant._rgb.toString() + ")"
                        this.$emit('setColors', this.colors)
                    })

                $(document).ready(function(){
                    $('.checked').prop('checked', true);
                    $("input").not(".checked").prop('checked', false);
                })

                this.getDevices();
            });
        },
        play(track, event) {
            event.preventDefault()
            var url = ""
            if(this.activeDevice){
                url = "https://api.spotify.com/v1/me/player/play";
            } else if (this.deviceRunningButNotActive){
                url = "https://api.spotify.com/v1/me/player/play?device_id=" + this.deviceRunningButNotActive.id;
            }
            var instance = axios.create();
            instance.defaults.headers.common = {};
            console.log(url)
            instance.put(url,
                {
                    "uris": [track.uri]
                },{
                headers : {
                    'Authorization' : this.accessTokenFull
                }
            }).then((response) => {
                if (202 === response.status) {
                    this.warning.show = true
                    this.warning.msg = "Nie masz żadnego aktywnego urządzenia"
                } else if (204 === response.status){
                    this.warning.show = true
                    this.warning.msg = "Odtwarzasz " + track.name + "  w swoim odtwarzaczu Spotify"
                }
                console.log(response)
                this.getDevices();
            })
        }
    }
}
</script>
