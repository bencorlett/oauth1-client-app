<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\OAuth1\Client\Client;

class FetchOAuthUserController
{
    public function __invoke(Request $request, Client $twitterClient)
    {
        $tokenCredentials = $request->session()->get('tokenCredentials', static function () {
            abort(Response::HTTP_FORBIDDEN);
        });

        $twitterClient->setTokenCredentials($tokenCredentials);

        $user = $twitterClient->fetchUserDetails();

        dd($user);

        return view('oauth.user')->with('user', $user);
    }
}
