<template>
<div>
	<!-- <container> -->
	<div class="container">
    	<div class="row featuredAlbums">
    		<h1 class="section-title">Najpopularniejsze <strong>na świecie</strong></h1>
	        <div class="col-sm-5ths" v-for="album in featuredAlbums.albums.items">
				<RatingStars v-if="render" :id="album.id" :userId="userId" :userRating="album.userRating" :roundAvgRating="album.roundAvgRating"></RatingStars>
				<p v-if="!render" class="trackRating--score">{{ album.avgRating }}</p>
				<router-link :to="'/album/' + album.id" class="featuredAlbums__single">
					<img :src="album.images[0].url" class="featuredAlbums__cover">
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
        	render: true,
        	featuredAlbums: {
        		albums: {
        			items: {}
    			}
    		},
        }
    }, 
    mounted() {
		if(this.userId){
			this.getFeaturedAlbums();
		}
    },
	watch: {
		userId: function () {
			if(this.userId){
				this.getFeaturedAlbums();
			}
		},
	},
    methods: {        
		getFeaturedAlbums() { 
            const url = '/api/spotify/featuredAlbums?limit=5';
            var instance = axios.create();
            instance.defaults.headers.common = {};
            instance.get(url, {
                headers : {
                    'Authorization' : this.accessToken,
                    'User' : this.userId
                }
            }).then((response) => {
                this.featuredAlbums = response.data
                this.render = false
                this.$nextTick(() => {
                    this.render = true
                })
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
