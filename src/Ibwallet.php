<?php
namespace Ib\IbWallet;
use Illuminate\Support\Facades\Http;
use Ib\IbWallet\Khalti\Khalti;
abstract class Ibwallet{

    public static function khalti($data){
        $obj = new Khalti();
        return $obj->Checkout($data);
    }

}

