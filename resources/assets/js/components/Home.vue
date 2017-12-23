<template>
    <div>
    	<div class="searchBox">
    		<input type="text" placeholder="Szukaj utworu lub albumu..."><span class="search fa fa-search"></span>
    	</div>
        <FeaturedAlbums 		:accessToken="accessToken"
        						:userId="userId"></FeaturedAlbums>
    </div>
</template>

<script>
export default {
	props: ['accessToken', 'userId'],
    data: function () {
        return {
        }
    }, 
}
</script>
