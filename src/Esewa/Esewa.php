<?php
namespace Ib\IbWallet\Esewa;
use Illuminate\Support\Facades\Http;

class Esewa{
    private $product_code;
    private $app_url;
    private $mode;
    private $default_url;
    private $failure_url;
    private $success_url;
    private $secret_key;

    public function __construct($product_code='',$app_url='',$mode='',$default_url='',$failure_url='',$success_url='',$secret_key=''){
        $this->product_code = config('ibwallet.esewa.product_code');
        $this->app_url = config('ibwallet.esewa.app_url');
        $this->mode = config('ibwallet.esewa.mode');
        $this->default_url = config('ibwallet.esewa.default_url');
        $this->failure_url = config('ibwallet.esewa.failure_url');
        $this->success_url = config('ibwallet.esewa.success_url');
        $this->secret_key = config('ibwallet.esewa.secret_key');
    }

    public function Checkout($payload){
        // dd(config('ibwallet.esewa.mode'));
        if($this->mode == NULL){
            throw new \Exception('Esewa Mode Not Found');
        }
        if(!$this->product_code){
            throw new \Exception('Esewa Product Code Not Found');
        }
        if(!$this->app_url){
            throw new \Exception('Esewa App Url Not Found');
        }
        if(!$this->default_url){
            throw new \Exception('Esewa Default Url Not Found');
        }
        if(!$this->failure_url){
            throw new \Exception('Esewa Failure Url Not Found');
        }
        if(!$this->success_url){
            throw new \Exception('Esewa Success Url Not Found');
        }
        if(!$this->secret_key){
            throw new \Exception('Esewa Secret Key Not Found');
        }
        $sig_message = $this->product_code.$payload['total_amount'].$payload['transaction_uuid'];
        $signature = hash_hmac('sha256',$sig_message, $this->secret_key,true);
        $sig = base64_encode($signature);
        $addon_payload = [
            'signature' => $sig,
            'failure_url' => $this->failure_url,
            'success_url' => $this->success_url,
            'product_code' => $this->product_code,
        ];
        $data = array_merge($payload, $addon_payload);
        // dd($data);
        if($this->mode == 0){
            // return $data;
            // $sendUrl = $this->default_url[0] . http_build_query($data);
            // dd($sendUrl);
            // $response = Http::get($sendUrl);
            // dd($response);
            return Http::post($this->default_url[0], $data);
        //    return $this->dispatch("redirectToEsewaPage",$data);
        }elseif($this->mode ==1){
            return Http::post($this->default_url[1], $data);
        }else{
            throw new \Exception('Esewa Mode Not Found');
        }
    }
}