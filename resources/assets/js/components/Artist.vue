<template>
    <div>
        <div class="container">
        	Widok artysty o id {{ $route.params.id }}
        </div>
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
