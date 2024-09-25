# IbWallet

This Laravel Package facilitates creating payments across multiple Nepalese wallets such as Khalti, eSewa, and more, offering versatile payment options in Nepal.
This support latest version of any package

### How to contribute

If you want to contribute this project. 
* email: basnetindra342@gmail.com

# Support Wallet
- Khalti : working
- Esewa : working 
- Parbhu Pay : coming
- Ime Pay : coming
- My Pay : coming

# Using Example

### Using Composer

```javascript
composer require ib/ib-wallet
```

### Publish Vendor File
```
php artisan vendor:publish --provider="Ib\IbWallet\IbWalletServiceProvider"
```
or 
```
php artisan vendor:publish
```
### using

```
use IbWallet;
```
paste in the controller
#### for Khalti

set env file (Here is a sample example)
* mode 0 for development
* mode 1 for production
```
KHALTI_CALLBACK_URL=http://127.0.0.1:8000/khalti-callback 
KHALTI_MODE=0
KHALTI_SECRET_KEY=

```
for khalti marchent 
* marchent url : https://test-admin.khalti.com/#/join/merchant
* use valid information.
* use otp: 987654  (this only for testing purpose)

```
 // if you have amount in rs, then you can use IbWallet::Khaltiamount('amount in rs'), this will response in paisa.
$payload = [
'amount' => 1000, // in paisa
'purchase_order_id' => '123456710', // most in unique
'purchase_order_name'=> 'test prod', // unique but not mendotary
'name'=> 'test bahadur', 
'phone'=> '01912345678',
'email'=> 'test@gmail.com',
'callback_url' => "http://127.0.0.1:8000/khalti-callback" // optional if you wnat to redirect custom url
];
// initate the payment to process the khalti payment
$initate_payment = IbWallet::khalti($payload);
// after initate payment. call checkout method to hit the checkout method
$checkout = IbWallet::KhaltiCheckout($initate_payment);
// this will redirect to khalti checkout section to fullfill the payment 
return $checkout;
//if your payment success then you auto redirect in callback url which you already set in env file.

```
 if you have amount in rs, then you can use IbWallet::Khaltiamount('amount in rs'), this will response in paisa.

 ```
 $amount = IbWallet::Khaltiamount('amount in rs');
 ```
 after successful payment and redirect on callback url which you already set in env file.
 then you can use get metod to print response or ib wallet provide a function for it.
 for print response
 ```
    //print khalti response after redirect success payment. 
    // here you can autometic redirect
    $response = IbWallet::KhaltiResponse();
 ```

 #### for esewa
 set the env file as seen
 * mode 0 for development
 * mode 1 for production
 * this secret key and product code only used on development, for production you need to contact with esewa
 ```
ESEWA_PRODUCT_CODE=EPAYTEST
ESEWA_MODE=0
ESEWA_FAILURE_URL=http://127.0.0.1:8000/esewa-fail
ESEWA_SUCCESS_URL=http://127.0.0.1:8000/esewa-success
ESEWA_SECRET_KEY=8gBm/:&EnhH.1/q
 ```

 in controller
 * DO not change the signature field. 
 ``` 
 $paylod =[
        'amount' => 1000, // in amount 
        'product_delivery_charge' => 0,
        'product_service_charge' => 0,
        'signed_field_names' =>"total_amount,transaction_uuid,product_code", // set signature field name, signature field auto generate
        'tax_amount' =>0,
        'total_amount' => 1000,
        // 'failure_url' =>"http://127.0.0.1:8000/esewa-fail" , // optional if you want to redirect to other page
        // 'success_url' =>"http://127.0.0.1:8000/esewa-success", // optional if you want to redirect to other page
        'transaction_uuid' => Str::random(20), // must be unique
    ];
return IbWallet::Esewa($paylod);

```
after success and falure payment you will auto redierect success and failure url which is set on .env file. Define the method like this
```
public function esewa_success(Request $request){
    // print your response
    // save your work on database or continue your work
    //dd($request->all());
     $response = IbWallet::EsewaResponse($request->all());
        // dd($response);
       print_r($response);
}

public function esewa_fail(Request $request){
    // print your response
    dd($request->all());
}

```
### Lisence
MIT

### Author
- Indra Basnet

### Support and FeedBack
email : basnetindra342@gmail.com

