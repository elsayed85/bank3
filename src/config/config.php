<?php

/**
 * Description of TurkeyBank.php
 *
 * @author Faruk Çam <mail@farukix.com>
 * Copyright (c) 2018 | farukix.com
 */

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
