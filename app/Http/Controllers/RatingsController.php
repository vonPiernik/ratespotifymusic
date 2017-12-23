<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Rating;

class RatingsController extends Controller
{
    public function store(Request $request)
    {
	    $validatedData = $request->validate([
	        'user_id' => 'required',
	        'item_id' => 'required',
	        'rating' => 'required',
	    ]);
	    // return $request->rating;
        $rating = Rating::updateOrCreate(
		    ['user_id' => $request->user_id, 'item_id' => $request->item_id],
		    ['rating' => $request->rating]
		);
        return $rating;
        //
    }

    public function average($item_id)
    {
    	return Rating::where('item_id', $item_id)->avg('rating');
    }

    public function my($user_id, $item_id)
    {
    	$query = Rating::where('item_id', $item_id)->where('user_id', $user_id)->select('rating')->first();
    	if(is_null($query)) return "norating";
		return $query->rating;
    }
}
