<?php

namespace App\Http\Controllers;

use Request;

use App\Rating;

use SpotifyWebAPI;


class SpotifyController extends Controller
{

    public function featuredAlbums()
    {
        $accessToken = Request::header('Authorization');
        $user_id = Request::header('User');

        if(Request::get('limit')){
            $limit = Request::get('limit');
        } else {
            $limit = 15;
        }

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
    	
        $result = $api->getNewReleases([ 'limit' => $limit ]);
        foreach ($result->albums->items as $key => $value) {
            $value->avgRating = Rating::where('item_id', $value->id)->avg('rating');
            $value->roundAvgRating = round(Rating::where('item_id', $value->id)->avg('rating'));
            $value->userRating = Rating::where('item_id', $value->id)->where('user_id', $user_id)->value('rating');
        }
        return response()->json($result);
    }

    public function search()
    {
        $accessToken = Request::header('Authorization');
        $query = Request::get('keywords');

        if(Request::get('limit')){
            $limit = Request::get('limit');
        } else {
            $limit = 20;
        }

        // $user_id = Request::header('User');

        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);



        $result = $api->search($query, 'artist,track,album',  [ 'limit' => $limit ]);

        foreach ($result->albums->items as $key => $value) {
            $value->avgRating = Rating::where('item_id', $value->id)->avg('rating');
        }
        foreach ($result->tracks->items as $key => $value) {
            $value->avgRating = Rating::where('item_id', $value->id)->avg('rating');
        }

        return response()->json($result);
    }

    public function album($id)
    {
        $accessToken = Request::header('Authorization');
        $user_id = Request::header('User');



        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        
        $result = $api->getAlbum($id);
        $result->avgRating = Rating::where('item_id', $id)->avg('rating');
        $result->roundAvgRating = round(Rating::where('item_id', $id)->avg('rating'));
        $result->userRating = Rating::where('item_id', $id)->where('user_id', $user_id)->value('rating');
        foreach ($result->tracks->items as $key => $value) {
            $value->avgRating = Rating::where('item_id', $value->id)->avg('rating');
            $value->roundAvgRating = round(Rating::where('item_id', $value->id)->avg('rating'));
            $value->userRating = Rating::where('item_id', $value->id)->where('user_id', $user_id)->value('rating');
        }
        return response()->json($result);
    }
}
