<?php 

namespace Ib\IbWallet;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Ib\IbWallet\IbWallet;
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
        AliasLoader::getInstance()->alias('IbWallet', IbWallet::class);
    }
}