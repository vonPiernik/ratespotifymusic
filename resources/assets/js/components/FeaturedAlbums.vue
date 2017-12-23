<template>
<div>
	<!-- <container> -->
	<div class="container">
    	<div class="row featuredAlbums">
    		<h1 class="section-title">Najpopularniejsze <strong>na świecie</strong></h1>
	        <div class="col-sm-5ths" v-for="album in featuredAlbums.albums.items">
				<a :href="album.external_urls.spotify" class="featuredAlbums__single" target="_BLANK">
					<img :src="album.images[0].url" class="featuredAlbums__cover">
					<div class="trackRating">
						<fieldset class="rating">
						    <input type="radio" v-on:change="rate" :id="album.id + '-star10'" :name="album.id" value="10" /><label class="full" :for="album.id + '-star10'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star9'" :name="album.id" value="9" /><label class="full" :for="album.id + '-star9'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star8'" :name="album.id" value="8" /><label class="full" :for="album.id + '-star8'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star7'" :name="album.id" value="7" /><label class="full" :for="album.id + '-star7'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star6'" :name="album.id" value="6" /><label class="full" :for="album.id + '-star6'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star5'" :name="album.id" value="5" /><label class="full" :for="album.id + '-star5'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star4'" :name="album.id" value="4" /><label class="full" :for="album.id + '-star4'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star3'" :name="album.id" value="3" /><label class="full" :for="album.id + '-star3'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star2'" :name="album.id" value="2" /><label class="full" :for="album.id + '-star2'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star1'" :name="album.id" value="1" /><label class="full" :for="album.id + '-star1'"></label>
						</fieldset>

						<p class="trackRating--score">{{ album.avgRating }}</p>
					</div>
					<div class="featuredAlbums__single__data">
						<div class="featuredAlbums__single__type">
							<span v-if="album.album_type == 'album'">Album</span><span v-else>Utwór</span>
						</div>
						<div class="featuredAlbums__single__name">
							<span>{{ album.name }}</span>
						</div>
						<div class="featuredAlbums__single__artist">
							<span v-for="artist in album.artists">{{ artist.name }} </span>
						</div>
					</div>
				</a>
	        </div>
	    </div>


    	<div class="row featuredAlbums featuredAlbums--PL">
    		<h1 class="section-title">Najpopularniejsze <strong>w Polsce</strong></h1>
	        <div class="col-sm-5ths" v-for="album in featuredAlbumsPL.albums.items">
				<a :href="album.external_urls.spotify" class="featuredAlbums__single" target="_BLANK">
					<img :src="album.images[0].url" class="featuredAlbums__cover">
					<div class="trackRating">
						<fieldset class="rating">
						    <input type="radio" v-on:change="rate" :id="album.id + '-star10'" :name="album.id" value="10" /><label class="full" :for="album.id + '-star10'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star9'" :name="album.id" value="9" /><label class="full" :for="album.id + '-star9'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star8'" :name="album.id" value="8" /><label class="full" :for="album.id + '-star8'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star7'" :name="album.id" value="7" /><label class="full" :for="album.id + '-star7'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star6'" :name="album.id" value="6" /><label class="full" :for="album.id + '-star6'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star5'" :name="album.id" value="5" /><label class="full" :for="album.id + '-star5'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star4'" :name="album.id" value="4" /><label class="full" :for="album.id + '-star4'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star3'" :name="album.id" value="3" /><label class="full" :for="album.id + '-star3'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star2'" :name="album.id" value="2" /><label class="full" :for="album.id + '-star2'"></label>
						    <input type="radio" v-on:change="rate" :id="album.id + '-star1'" :name="album.id" value="1" /><label class="full" :for="album.id + '-star1'"></label>
						</fieldset>

						<p class="trackRating--score">{{ album.avgRating }}</p>
					</div>
					<div class="featuredAlbums__single__data">
						<div class="featuredAlbums__single__type">
							<span v-if="album.album_type == 'album'">Album</span><span v-else>Utwór</span>
						</div>
						<div class="featuredAlbums__single__name">
							<span>{{ album.name }}</span>
						</div>
						<div class="featuredAlbums__single__artist">
							<span v-for="artist in album.artists">{{ artist.name }} </span>
						</div>
					</div>
				</a>
	        </div>
	    </div>
	</div> 
	<!-- </container> -->

</div>
</template>

<script>
export default {
	props: ['accessToken', 'userId'],
    data: function () {
        return {
        	featuredAlbums: {
        		albums: {
        			items: {}
    			}
    		},
        	featuredAlbumsPL: {
        		albums: {
        			items: {}
    			}
    		},
        }
    }, 
    mounted() {

    },
	watch: {
		userId: function () {
			if(this.userId.length > 0){
				this.getFeaturedAlbums();
				this.getFeaturedAlbumsPL();
			}
		},
	},
    methods: {        
		getFeaturedAlbums() { 
            const url = 'https://api.spotify.com/v1/browse/new-releases?limit=5';
            var instance = axios.create();
            instance.defaults.headers.common = {};
            instance.get(url, {
                headers : {
                    'Authorization' : this.accessToken
                }
            }).then((response) => {
                this.featuredAlbums = response.data
	        	var userId = this.userId

                _.forEach(this.featuredAlbums.albums.items, function (album, key) {
		        	axios.get('/api/ratings/' + userId + '/' + album.id)
					.then(function (response) {
						if(response.data != "norating"){
							album.userRating = response.data;

							document.getElementById(album.id + "-star" + album.userRating).checked = true;
						}
					})
		        	axios.get('/api/ratings/' + album.id)
					.then(function (response) {
						if(response.data != "norating"){

							album.avgRating = response.data;
							album.name = album.name + " "

							var roundedRating = _.round(album.avgRating)
							document.getElementById(album.id + "-star" + roundedRating).classList.add('avgRating')
						}
					})

				})
            });
        },
		getFeaturedAlbumsPL() { 
            const url = 'https://api.spotify.com/v1/browse/new-releases?limit=5&country=PL';
            var instance = axios.create();
            instance.defaults.headers.common = {};
            instance.get(url, {
                headers : {
                    'Authorization' : this.accessToken
                }
            }).then((response) => {
                this.featuredAlbumsPL = response.data
                var userId = this.userId

                _.forEach(this.featuredAlbumsPL.albums.items, function (album, key) {
		        	axios.get('/api/ratings/' + userId + '/' + album.id)
					.then(function (response) {
						if(response.data != "norating"){
							album.userRating = response.data;

							document.getElementById(album.id + "-star" + album.userRating).checked = true;
						}
					})
		        	axios.get('/api/ratings/' + album.id)
					.then(function (response) {
						if(response.data != "norating"){

							album.avgRating = response.data;
							album.name = album.name + " "

							var roundedRating = _.round(album.avgRating)
							document.getElementById(album.id + "-star" + roundedRating).classList.add('avgRating')
						}
					})

				})
            });
        },
        rate: function(event){
        	axios.post('/api/ratings', {
				user_id: this.userId,
				item_id: event.target.name,
				rating: event.target.value
			})
			.then(function (response) {
				// console.log(response);
			})
			.catch(function (error) {
				console.log(error);
			});
        }
    }
}
</script>
