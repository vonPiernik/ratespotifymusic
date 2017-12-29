<template>
<div>
    <div class="trackRating">
        <fieldset class="rating">
            <input  type="radio"
            v-on:change="rate"
            :class="{ 'checked': (userRating == 10), 'avgRating':(roundAvgRating == 10) }" :name="id" :id="id + '-star10'" value="10" />
            <label class="full" :for="id + '-star10'"></label>
            <input type="radio"
            v-on:change="rate"
            :class="{ 'checked': (userRating == 9), 'avgRating':(roundAvgRating == 9) }" :name="id" :id="id + '-star9'" value="9" />
            <label class="full" :for="id + '-star9'"></label>
            <input  type="radio"
            v-on:change="rate"
            :class="{ 'checked': (userRating == 8), 'avgRating':(roundAvgRating == 8) }" :name="id" :id="id + '-star8'" value="8" />
            <label class="full" :for="id + '-star8'"></label>
            <input  type="radio"
            v-on:change="rate"
            :class="{ 'checked': (userRating == 7), 'avgRating':(roundAvgRating == 7) }" :name="id" :id="id + '-star7'" value="7" />
            <label class="full" :for="id + '-star7'"></label>
            <input  type="radio"
            v-on:change="rate"
            :class="{ 'checked': (userRating == 6), 'avgRating':(roundAvgRating == 6) }" :name="id" :id="id + '-star6'" value="6" />
            <label class="full" :for="id + '-star6'"></label>
            <input  type="radio"
            v-on:change="rate"
            :class="{ 'checked': (userRating == 5), 'avgRating':(roundAvgRating == 5) }" :name="id" :id="id + '-star5'" value="5" />
            <label class="full" :for="id + '-star5'"></label>
            <input  type="radio"
            v-on:change="rate"
            :class="{ 'checked': (userRating == 4), 'avgRating':(roundAvgRating == 4) }" :name="id" :id="id + '-star4'" value="4" />
            <label class="full" :for="id + '-star4'"></label>
            <input  type="radio"
            v-on:change="rate"
            :class="{ 'checked': (userRating == 3), 'avgRating':(roundAvgRating == 3) }" :name="id" :id="id + '-star3'" value="3" />
            <label class="full" :for="id + '-star3'"></label>
            <input  type="radio"
            v-on:change="rate"
            :class="{ 'checked': (userRating == 2), 'avgRating':(roundAvgRating == 2) }" :name="id" :id="id + '-star2'" value="2" />
            <label class="full" :for="id + '-star2'"></label>
            <input  type="radio"
            v-on:change="rate"
            :class="{ 'checked': (userRating == 1), 'avgRating':(roundAvgRating == 1) }" :name="id" :id="id + '-star1'" value="1" />
            <label class="full" :for="id + '-star1'"></label>
        </fieldset>
    </div>
</div>
</template>

<script>
export default {
    props: ['id', 'userRating', 'roundAvgRating', 'userId'],
    data: function () {
        return {
        }
    },
    methods: {
        rate(){
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
