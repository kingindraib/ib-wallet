# IbWallet

This Laravel Package allow to create payment in multiple wallet for nepal like khalti, esewa and others. 
this package is underconstruction now.

# Support Wallet
- Khalti : on Testing
- Esewa : coming
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
```
$payload = [
    'amount' => 100 //in paisa
    'purchase_order_id' => 1110 //must be unique
    'purchase_order_name' => 'product name' 
    'name' => 'customer name'
    'email' => 'customer email'
    'phone' => 'customer phone'
];
$response = IbWallet::Khalti($payload);

```
Note : this will may be change

### Lisence
MIT

### Author
- Indra Basnet

### Support and FeedBack
email : basnetindra342@gmail.com

