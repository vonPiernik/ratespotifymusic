<template>
    <div>
    	<div class="searchBox">
    		<input type="text" placeholder="Szukaj utworu lub albumu..." v-model="keywords"><span class="search fa fa-search"></span>
            <ul class="searchSuggest">
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
                        {{ item.name }} <small>( <span v-for="artist in item.artists">{{ artist.name }} </span>)</small>

                        <span class="searchSuggets__rating" v-if="item.avgRating">{{ item.avgRating }} / 10</span>
                    </li>
                </div>
                <div class="li-wrapper li-wrapper--albums" v-if="result.albums.items.length > 0">
                <span class="searchSuggest__label">Albumy</span>
                    <li v-for="item in result.albums.items">
                        <div class="searchSuggest__albumCoverWrapper"><img v-if="item.images.length > 0" :src="item.images[1].url" class="searchSuggest__albumCover"></div>
                        {{ item.name }} 
                    </li>
                </div>
            </ul>
    	</div>


        <FeaturedAlbums 		:accessToken="accessToken"
        						:userId="userId">
        </FeaturedAlbums>
    </div>
</template>

<script>
export default {
	props: ['accessToken', 'userId'],
    data: function () {
        return {
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
            }
        }
    }, 
    watch: {
        keywords: {
            handler: function(after, before) {
                if(this.keywords.length > 2){
                    this.search()
                }
            }
        }
    },
    methods: {
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
                    console.log(response.data)
                });
            }
        ,500)
    }
}
</script>
