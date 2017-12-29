<template>
    <div>
<!--         <RecentlyPLayed         :accessToken="accessToken"
                                :userId="userId">
        </RecentlyPLayed> -->
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
