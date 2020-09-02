<?php

namespace App\Http\Controllers;

use App\TwitterClient;
use Illuminate\Http\Request;
use League\OAuth1\Client\Client;

class StartOAuthController
{
    public function __invoke(Request $request, Client $twitterClient)
    {
        $temporaryCredentials = $twitterClient->fetchTemporaryCredentials();

        $request->session()->flash('temporaryCredentials', $temporaryCredentials);

        $authorizationRequest = $twitterClient->prepareAuthorizationRequest($temporaryCredentials);

        return view('oauth.start')
            ->with('authorizationRequest', $authorizationRequest);
    }
}
