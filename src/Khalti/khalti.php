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
        // parent::__construct();
        $this->secret_key = config('khalti.secret_key');
        $this->url = config('khalti.default_url');
        $this->mode = config('khalti.mode');
        $this->callback = config('khalti.callback_url');
    }

    public function Checkout(array $data){
        $payload = [
            'return_url' => $this->callback,
            'website_url' => $this->callback,
            'amount' => $data['amount'],
            'purchase_order_id' => $data['purchase_order_id'],
            'purchase_order_name' => $data['purchase_order_name'],
            'customer_info' => [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ],
        ];
        $header = [
            'Authorization' => 'Key '.$this->secret_key,
            'Content-Type' => 'application/json',
        ];
        if($this->mode == 0){
            $response = Http::withHeaders($header)->post($this->url[0].'/epayment/initiate/', $payload);
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

    public static function verify($token){
        $response = Http::post(config('ibwallet.url').'/api/verify',[
            'token'=>$token
        ]);
        return $response->json();
    }

    public static function verifyPayment($token){
        $response = Http::post(config('ibwallet.url').'/api/verifyPayment',[
            'token'=>$token
        ]);
        return $response->json();
    }

    public static function verifyPaymentStatus($token){
        $response = Http::post(config('ibwallet.url').'/api/verifyPaymentStatus',[
            'token'=>$token
        ]);
        return $response->json();
    }

    public static function verifyPaymentStatusByRefId($ref_id){
        $response = Http::post(config('ibwallet.url').'/api/verifyPaymentStatusByRefId',[
            'ref_id'=>$ref_id
        ]);
        return $response->json();
    }
}