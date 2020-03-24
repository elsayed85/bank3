# Laravel 7 Kuveyt Turk

```
composer require elsayed85/bank3
```

`config/app.php`

```php
return [
    // ...

    'providers' => [
        // ...

        elsayed85\bank3\TurkeyBankServiceProvider::class
    ],

    // ...

    'aliases' => [
        // ...

        'TurkeyBank'    => elsayed85\bank3\Facades\TurkeyBank::class
    ],
);
```

# publishing

```code
php artisan vendor:publish
```

`config/TurkeyBank.php`

### TurkeyBank.php

```php
return [
    "Type"                => "Sale",
    "APIVersion"          => "1.0.0",
    "ApiUrl"              => "https://boa.kuveytturk.com.tr/sanalposservice/Home/ThreeDModelPayGate", // Test API url : https://boatest.kuveytturk.com.tr/boa.virtualpos.services/Home/ThreeDModelPayGate
    "CustomerId"          => "400235", // Test Müşteri Numarası : 400235
    "CurrencyCode"        => "0949", // Para birimi TL 0949
    "MerchantId"          => "496", // Test Magaza Kodu : 496
    "OkUrl"               => env('KUVEYT_TURK_API_OKURL', "done"),
    "FailUrl"             => env('KUVEYT_TURK_API_FAILURL', "fail"),
    "UserName"            => env('KUVEYT_TURK_API_USERNAME', "username"), // Test API Kullanıcısı : apiuser1
    "Password"            => env('KUVEYT_TURK_API_PASSWORD', 'password'),  // Test API Kullanıcı Şifresi : Api123
    "TransactionSecurity" => "3" // 3d Secure = 3 , 3d'siz = 1
];

```

### .env

```php
// [fail] and [done] is a route in web.php
KUVEYT_TURK_API_CUSTOMER_ID=123
KUVEYT_TURK_API_MERCHANT_ID=27003
KUVEYT_TURK_API_OKURL=done
KUVEYT_TURK_API_FAILURL=fail
KUVEYT_TURK_API_USERNAME=apiuser1
KUVEYT_TURK_API_PASSWORD=Api123
```

```php
use TurkeyBank;

public function index()
{
    $TurkeyBank = TurkeyBank::setName('test test')
        ->setCardNumber(1234567891234567)
        ->setCardExpireDateMonth(02)
        ->setCardExpireDateYear(20)
        ->setCardCvv2(123)
        ->setOrderId(12345)
        ->setAmount(100)
        ->pay();
}
```

### web.php

```php

// for fail request debugging
Route::post('/fail', function (Request $request) {
    if($request->AuthenticationResponse) {
        $RequestContent = urldecode($request->AuthenticationResponse);
        $data =  simplexml_load_string($RequestContent) or die("Error: Cannot create object");
        dd($request , $RequestContent , $data);
    }
    return "failed!";
});

// for success request debugging
Route::post('/done', function (Request $request) {
    if($request->AuthenticationResponse) {
        $RequestContent = urldecode($request->AuthenticationResponse);
        $data =  simplexml_load_string($RequestContent) or die("Error: Cannot create object");
        dd($request , $RequestContent , $data);
    }
    return "done!";
});


```
