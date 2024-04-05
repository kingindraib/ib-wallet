<?php
namespace Ib\IbWallet;
use Illuminate\Support\Facades\Http;
use Ib\IbWallet\Khalti\Khalti;
use Ib\IbWallet\Esewa\Esewa;
abstract class Ibwallet{

    public static function khalti($payload = []){
        // dd($data);
        if(!empty($payload)){
            $obj = new Khalti();
            return $obj->Checkout($payload);
        }else{
            throw new \Exception('payload is empty please set data in array in $payload');
        }
        
       
    }
    public static function KhaltiCheckout($payload = []){
        // dd($data);
        if(!empty($payload)){
            return redirect($payload['payment_url']);
        }else{
            throw new \Exception('payload is empty please set data in array in $payload');
        }

    }

    public static function KhaltiResponse(){
        return $_GET;
    }

    public static function Khaltiamount($amount){
        return $amount*100;
    }

    
    public static function Esewa($payload=[]){
        if(!empty($payload)){
            $obj = new Esewa();
            return $obj->Checkout($payload);
        }else{
            throw new \Exception('payload is empty please set data in array in $payload');
        }
    }

}

