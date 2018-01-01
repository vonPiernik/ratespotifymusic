<template>
    <div>
<!--         <RecentlyPlayed         :accessToken="accessToken"
                                :userId="userId">
        </RecentlyPlayed> -->
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
        }
    }, 
    methods: {
    }
}
</script>
