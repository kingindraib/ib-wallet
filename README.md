# IbWallet

This Laravel Package facilitates creating payments across multiple Nepalese wallets such as Khalti, eSewa, and more, offering versatile payment options in Nepal.
This support latest version of any package


# Support Wallet
- Khalti : working
- Esewa : working (prerelese)
- Parbhu Pay : coming
- Ime Pay : coming
- My Pay : coming

# Using Example

### Using Composer

```javascript
composer require ib/ib-wallet
```

### Add Four Variable in .env

This Section will update soon

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
marchent url : https://test-admin.khalti.com/#/join/merchant
use valid information.
use otp: 987654  (this only for testing purpose)

```
 $payload = [
        'amount' => 1000, // in paisa
        'purchase_order_id' => '123', // most in unique
        'purchase_order_name'=> 'test', // unique but not mendotary
        'name'=> 'test bahadur', 
        'phone'=> '01912345678',
        'email'=> 'test@gmail.com',
    ];
$response = IbWallet::khalti($payload);
// save response on database
$checkout = IbWallet::KhaltiCheckout($response);
return $checkout;
if your payment success then you auto redirect in callback url which you already set in env file.
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
 this secret key and product code only used on development, for production you need to contact with esewa
 ```
ESEWA_PRODUCT_CODE=EPAYTEST
ESEWA_MODE=0
ESEWA_FAILURE_URL=http://127.0.0.1:8000/esewa-success
ESEWA_SUCCESS_URL=http://127.0.0.1:8000/esewa-fail
ESEWA_SECRET_KEY=8gBm/:&EnhH.1/q
 ```

 in controller
 ``` 
 $paylod =[
    'amount' => 1000, // in amount 
    'product_delivery_charge' => 0,
    'product_service_charge' => 0,
    'signed_field_names' =>"total_amount,transaction_uuid,product_code", // set signature field name, signature field auto generate
    'tax_amount' =>0,
    'total_amount' => 1000,
    'transaction_uuid' => '1234567', // must be unique
];
return IbWallet::Esewa($paylod);

```
after success and falure payment you will auto redierect success and failure url which is set on .env file
```
public function esewa_success(Request $request){
    // print your response
    // save your work on database or continue your work
    dd($request->all());
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

