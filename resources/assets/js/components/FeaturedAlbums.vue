<template>
<div>
	<!-- <container> -->
	<div class="container">
    	<div class="row featuredAlbums">
    		<h1 class="section-title">Najpopularniejsze <strong>na świecie</strong></h1>
	        <div class="col-sm-5ths" v-for="album in featuredAlbums.albums.items">
				<router-link :to="'/album/' + album.id" class="featuredAlbums__single">
					<img :src="album.images[0].url" class="featuredAlbums__cover">
					<div class="trackRating">
						<fieldset class="rating">
						    <input 	type="radio" 
						    		v-on:change="rate" 
						    		:class="{ 'checked': (album.userRating == 10), 'avgRating':(album.roundAvgRating == 10) }" :name="album.id" :id="album.id + '-star10'" value="10" />
						    <label class="full" :for="album.id + '-star10'"></label>

						    <input type="radio" 
						    		v-on:change="rate" 
						    		:class="{ 'checked': (album.userRating == 9), 'avgRating':(album.roundAvgRating == 9) }" :name="album.id" :id="album.id + '-star9'" value="9" />
						    <label class="full" :for="album.id + '-star9'"></label>

						    <input 	type="radio" 
						    		v-on:change="rate" 
						    		:class="{ 'checked': (album.userRating == 8), 'avgRating':(album.roundAvgRating == 8) }" :name="album.id" :id="album.id + '-star8'" value="8" />
						    <label class="full" :for="album.id + '-star8'"></label>

						    <input 	type="radio" 
						    		v-on:change="rate" 
						    		:class="{ 'checked': (album.userRating == 7), 'avgRating':(album.roundAvgRating == 7) }" :name="album.id" :id="album.id + '-star7'" value="7" />
						    <label class="full" :for="album.id + '-star7'"></label>

						    <input 	type="radio" 
						    		v-on:change="rate" 
						    		:class="{ 'checked': (album.userRating == 6), 'avgRating':(album.roundAvgRating == 6) }" :name="album.id" :id="album.id + '-star6'" value="6" />
						    <label class="full" :for="album.id + '-star6'"></label>

						    <input 	type="radio" 
						    		v-on:change="rate" 
						    		:class="{ 'checked': (album.userRating == 5), 'avgRating':(album.roundAvgRating == 5) }" :name="album.id" :id="album.id + '-star5'" value="5" />
						    <label class="full" :for="album.id + '-star5'"></label>

						    <input 	type="radio" 
						    		v-on:change="rate" 
						    		:class="{ 'checked': (album.userRating == 4), 'avgRating':(album.roundAvgRating == 4) }" :name="album.id" :id="album.id + '-star4'" value="4" />
						    <label class="full" :for="album.id + '-star4'"></label>

						    <input 	type="radio" 
						    		v-on:change="rate" 
						    		:class="{ 'checked': (album.userRating == 3), 'avgRating':(album.roundAvgRating == 3) }" :name="album.id" :id="album.id + '-star3'" value="3" />
						    <label class="full" :for="album.id + '-star3'"></label>

						    <input 	type="radio" 
						    		v-on:change="rate" 
						    		:class="{ 'checked': (album.userRating == 2), 'avgRating':(album.roundAvgRating == 2) }" :name="album.id" :id="album.id + '-star2'" value="2" />
						    <label class="full" :for="album.id + '-star2'"></label>

						    <input 	type="radio" 
						    		v-on:change="rate" 
						    		:class="{ 'checked': (album.userRating == 1), 'avgRating':(album.roundAvgRating == 1) }" :name="album.id" :id="album.id + '-star1'" value="1" />
						    <label class="full" :for="album.id + '-star1'"></label>

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
				</router-link>
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
        }
    }, 
    mounted() {
		if(this.userId.length > 0){
			this.getFeaturedAlbums();
		}
    },
	watch: {
		userId: function () {
			if(this.userId.length > 0){
				this.getFeaturedAlbums();
			}
		},
	},
    methods: {        
		getFeaturedAlbums() { 
            const url = '/api/spotify/featuredAlbums';
            var instance = axios.create();
            instance.defaults.headers.common = {};
            instance.get(url, {
                headers : {
                    'Authorization' : this.accessToken,
                    'User' : this.userId
                }
            }).then((response) => {
                this.featuredAlbums = response.data
                $(document).ready(function(){
                	$('.checked').prop('checked', true);
                })
            });
        },
        rate: function(event){
        	event.preventDefault()
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
