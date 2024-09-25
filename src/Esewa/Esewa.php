<?php
namespace Ib\IbWallet\Esewa;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class Esewa
{
    private $product_code;
    private $app_url;
    private $mode;
    private $default_url;
    private $failure_url;
    private $success_url;
    private $secret_key;

    public function __construct($product_code = '', $app_url = '', $mode = '', $default_url = '', $failure_url = '', $success_url = '', $secret_key = '')
    {
        $this->product_code = config('ibwallet.esewa.product_code');
        $this->app_url = config('ibwallet.esewa.app_url');
        $this->mode = config('ibwallet.esewa.mode');
        $this->default_url = config('ibwallet.esewa.default_url');
        $this->failure_url = config('ibwallet.esewa.failure_url');
        $this->success_url = config('ibwallet.esewa.success_url');
        $this->secret_key = config('ibwallet.esewa.secret_key');
    }

    public function Checkout($payload)
    {
        // dd(config('ibwallet.esewa.mode'));
        if(isset($payload['failure_url'])){
            $this->failure_url = $payload['failure_url'];
        }
        if(isset($payload['success_url'])){
            $this->success_url = $payload['success_url'];
        }
 
        if ($this->mode == NULL) {
            throw new \Exception('Esewa Mode Not Found');
        }
        if (!$this->product_code) {
            throw new \Exception('Esewa Product Code Not Found');
        }
        if (!$this->app_url) {
            throw new \Exception('Esewa App Url Not Found');
        }
        if (!$this->default_url) {
            throw new \Exception('Esewa Default Url Not Found');
        }
        if (!$this->failure_url) {
            throw new \Exception('Esewa Failure Url Not Found');
        }
        if (!$this->success_url) {
            throw new \Exception('Esewa Success Url Not Found');
        }
        if (!$this->secret_key) {
            throw new \Exception('Esewa Secret Key Not Found');
        }
        $sig_message = "total_amount={$payload['total_amount']},transaction_uuid={$payload['transaction_uuid']},product_code={$this->product_code}";
   
        $signature = hash_hmac('sha256', $sig_message, $this->secret_key, true);
        $sig = base64_encode($signature);
       
        $addon_payload = [
            'signature' => $sig,
            'failure_url' => $this->failure_url,
            'success_url' => $this->success_url,
            'product_code' => $this->product_code,
        ];
        $data = array_merge($payload, $addon_payload);

        if ($this->mode == 0) {
  
            return $this->payToesewa($this->default_url[0], $data);

        } elseif ($this->mode == 1) {

            return $this->payToesewa($this->default_url[1], $data);
        } else {
            throw new \Exception('Esewa Mode Not Found');
        }
    }

    public function payToesewa($url, $postData)
    {

        $form = '<form id="esewa_payment_form" method="POST" action="' . $url . '">';
        foreach ($postData as $key => $value) {
            $form .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
        }
        $form .= '</form>';
        $form .= '<script type="text/javascript">document.getElementById("esewa_payment_form").submit();</script>';
        return $form;
    }

}
