<?php

namespace App\Providers;

use AmoCRM\Client\AmoCRMApiClient;
use App\AmoCrmService;
use App\AmoCrmTokenStore;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AmoCrmService::class, function () {

            $apiClient = new AmoCRMApiClient(
                config('amo-crm.id'),
                config('amo-crm.key'),
                config('amo-crm.url'),
            );

            $apiClient->setAccountBaseDomain(config('amo-crm.domain'));

            $tokenStore = new AmoCrmTokenStore();

            return new AmoCrmService($apiClient, $tokenStore);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
