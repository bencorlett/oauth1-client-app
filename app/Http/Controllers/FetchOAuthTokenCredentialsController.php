<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use League\OAuth1\Client\Client;

class FetchOAuthTokenCredentialsController
{
    public function __invoke(Request $request, Client $twitterClient)
    {
        $temporaryCredentials = $request->session()->pull('temporaryCredentials', static function () {
            abort(Response::HTTP_FORBIDDEN);
        });

        if (!$request->has('oauth_verifier')) {
            abort(Response::HTTP_BAD_REQUEST);
        }

        $tokenCredentials = $twitterClient->fetchTokenCredentials(
            $temporaryCredentials,
            $request->get('oauth_verifier')
        );

        $request->session()->put('tokenCredentials', $tokenCredentials);

        return Redirect::to('/user');
    }
}
