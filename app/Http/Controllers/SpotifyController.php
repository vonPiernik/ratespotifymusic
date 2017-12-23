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
        $api = new SpotifyWebAPI\SpotifyWebAPI();
        $api->setAccessToken($accessToken);
    	
        $result = $api->getNewReleases();
        foreach ($result->albums->items as $key => $value) {
            $value->avgRating = Rating::where('item_id', $value->id)->avg('rating');
            $value->userRating = Rating::where('item_id', $value->id)->where('user_id', $user_id)->value('rating');
        }
        return response()->json($result);
    }
}
