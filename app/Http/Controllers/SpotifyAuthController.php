<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebAPI;
class SpotifyAuthController extends Controller
{


	public function home()
	{
		if(session('accessToken')){
			// echo session('accessToken');
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
	    	require '../vendor/autoload.php';

			$api = new SpotifyWebAPI\SpotifyWebAPI();

			// Fetch the saved access token from somewhere. A database for example.

			$api = new SpotifyWebAPI\SpotifyWebAPI();
			$api->setAccessToken(session()->get('accessToken'));

			return view('app')->with('api', $api);
		} else {
			return redirect('/auth');			
		}
	}


	public function callback()
	{
    	require '../vendor/autoload.php';

		$session = new SpotifyWebAPI\Session(
		    'f6004f63970b446285d2aa72c019cd7c',
		    '83577c88727844e29cda981cf4e5eab9',
		    'http://localhost:8000/callback'
		);

		// Request a access token using the code from Spotify
		$session->requestAccessToken($_GET['code']);

		$accessToken = $session->getAccessToken();
		$refreshToken = $session->getRefreshToken();

		// Store the access and refresh tokens somewhere. In a database for example.
		session(['accessToken' => $accessToken, 'refreshToken' => $refreshToken]);

		// Send the user along and fetch some data!
		return redirect('/');
	}


    public function auth()
    {
    	require '../vendor/autoload.php';

		$session = new SpotifyWebAPI\Session(
		    'f6004f63970b446285d2aa72c019cd7c',
		    '83577c88727844e29cda981cf4e5eab9',
		    'http://localhost:8000/callback'
		);

		$options = [
		    'scope' => [
		        'playlist-read-private',
		        'user-read-private',
		    ],
		];
		header('Location: ' . $session->getAuthorizeUrl($options));
		die();
    }

    public function api()
    {
    	require '../vendor/autoload.php';

		$api = new SpotifyWebAPI\SpotifyWebAPI();

		// Fetch the saved access token from somewhere. A database for example.

		$api = new SpotifyWebAPI\SpotifyWebAPI();
		$api->setAccessToken(session()->get('accessToken'));
		return session()->all();
    }
}
