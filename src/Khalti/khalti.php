<?php
namespace Ib\IbWallet\Khalti;
use Illuminate\Support\Facades\Http;
// use Ib\IbWallet\Khalti\KhaltiException;
use Ib\IbWallet\Ibwallet;

class Khalti extends Ibwallet{

    private $secret_key;
    private $mode;
    private $url;
    private $callback;

    public function __construct($secret_key,$mode,$callback){
        $this->secret_key = config('khalti.secret_key');
        $this->url = config('khalti.default_url');
        $this->mode = config('khalti.mode');
        $this->callback = config('khalti.callback_url');
    }

    public function Checkout($amount, $phone, $email, $product_info, $order_id){
        $payload = [
            'amount' => $amount,
            'phone' => $phone,
            'email' => $email,
            'product_info' => $product_info,
            'order_id' => $order_id,
            'secret_key' => $this->secret_key,
            'return_url' => $this->callback,
            'webhook' => $this->callback,
            'allow_repeated_payments' => false
        ];
        if($this->mode == 0){
            $response = Http::post($this->url[0].'/epayment/initiate/', $payload);
        }else{
            $response = Http::post($this->url[1].'/epayment/initiate/', $payload);
        }
        
        if($response->successful()){
            return $response->json();
        }else{
            throw new \Exception('Khalti Checkout Failed');
            // throw new KhaltiException('Khalti Checkout Failed');
        }
    }
}