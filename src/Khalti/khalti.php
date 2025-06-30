<?php
namespace Ib\IbWallet\Khalti;
use Illuminate\Support\Facades\Http;
// use Ib\IbWallet\Khalti\KhaltiException;
use Ib\IbWallet\Ibwallet;

class Khalti{

    private $secret_key;
    private $mode;
    private $url;
    private $callback;
    private $app_url;

    protected $success_response;

    public function __construct($secret_key='',$mode='',$callback=''){
        // parent::__construct();
        $this->secret_key = config('ibwallet.khalti.secret_key');
        $this->url = config('ibwallet.khalti.default_url');
        $this->mode = config('ibwallet.khalti.mode');
        $this->callback = config('ibwallet.khalti.callback_url');
        $this->app_url = config('ibwallet.khalti.app_url');
    }     

    public function Checkout(array $data){
        if(isset($data['callback_url'])){
            $this->callback = $data['callback_url'];
        }

        if(!$this->secret_key){
            throw new \Exception('Khalti Secret Key Not Found');
        }
        if($this->mode == NULL){
            throw new \Exception('Khalti Mode Not Found');
        }
        if(!$this->callback){
            throw new \Exception('Khalti Callback Not Found');
        }
        if(!$this->app_url){
            throw new \Exception('Khalti App Url Not Found');
        }

        $payload = [
            'return_url' => $this->callback,
            'website_url' => $this->app_url,
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
            $response = Http::withHeaders($header)->post($this->url[0].'epayment/initiate/', $payload);
        }elseif($this->mode == 1){
            $response = Http::withHeaders($header)->post($this->url[1].'epayment/initiate/', $payload);
        }else{
            throw new \Exception('Khalti Mode Not Found');
        }
        
        if($response->successful()){
            $this->success_response = $response;
            return $response->json();
        }else{
            throw new \Exception('Khalti Checkout Failed');
            // throw new KhaltiException('Khalti Checkout Failed');
        }
    }


    public  function pay($data =[]){

    }
}