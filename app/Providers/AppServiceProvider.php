<?php

namespace App\Providers;

use App\TwitterClient;
use GuzzleHttp\Client as HttpClient;
use Http\Factory\Guzzle\RequestFactory;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use League\OAuth1\Client\Client as OAuth1Client;
use League\OAuth1\Client\Credentials\ClientCredentials;
use League\OAuth1\Client\Provider\Twitter;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RequestFactoryInterface::class, static function (): RequestFactory {
            return new RequestFactory();
        });

        $this->app->bind(ClientInterface::class, static function (): HttpClient {
            return new HttpClient();
        });

        $this->app->bind(OAuth1Client::class, static function ($app): OAuth1Client {
            $credentials = new ClientCredentials(
                config('services.twitter.identifier'),
                config('services.twitter.secret'),
                url(config('services.twitter.callback')),
                config('services.twitter.realm')
            );

            return new OAuth1Client(
                new Twitter($credentials),
                $app[RequestFactoryInterface::class],
                $app[ClientInterface::class]
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
