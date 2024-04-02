<?php 

namespace Ib\IbWallet;

use Illuminate\Support\ServiceProvider;
class IbWalletServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind('ib-wallet', function () {
        //     return new IbWallet;
        // });
    }
}