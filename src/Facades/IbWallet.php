<?php

namespace Ib\IbWallet\Facades;

use Illuminate\Support\Facades\Facade;

class IbWallet extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ibwallet'; 
    }
}