<?php

/**
 * Description of TurkeyBank.php
 *
 * @author Faruk Çam <mail@farukix.com>
 * Copyright (c) 2018 | farukix.com
 */

namespace elsayed85\bank3\Http\Base;

use Config;
use Exception;

class TurkeyBank extends BaseClass
{
    protected function process()
    {
        $HashedPassword = base64_encode(sha1(Config::get("TurkeyBank.Password"), "ISO-8859-9")); // md5($Password);
        $HashData = base64_encode(
            sha1(Config::get("TurkeyBank.MerchantId")
                . $this->orderid . $this->amount
                . ($this->successurl ? $this->successurl : Config::get("TurkeyBank.OkUrl"))
                . ($this->errorurl ? $this->errorurl :  Config::get("TurkeyBank.FailUrl"))
                . Config::get("TurkeyBank.UserName") . $HashedPassword, "ISO-8859-9")
        );

        $xml = '<KuveytTurkVPosMessage xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">'
            . '<APIVersion>' . Config::get("TurkeyBank.APIVersion") . '</APIVersion>'
            . '<OkUrl>' . ($this->successurl ? $this->successurl : Config::get("TurkeyBank.OkUrl")) . '</OkUrl>'
            . '<FailUrl>' . ($this->errorurl ? $this->errorurl :  Config::get("TurkeyBank.FailUrl")) . '</FailUrl>'
            . '<HashData>' . $HashData . '</HashData>'
            . '<MerchantId>' . Config::get("TurkeyBank.MerchantId") . '</MerchantId>'
            . '<CustomerId>' . Config::get("TurkeyBank.CustomerId") . '</CustomerId>'
            . '<UserName>' . Config::get("TurkeyBank.UserName") . '</UserName>'
            . '<CardNumber>' . $this->cardnumber . '</CardNumber>'
            . '<CardExpireDateYear>' . ($this->cardexpiredateyear < 10 ? '0' . $this->cardexpiredateyear : $this->cardexpiredateyear) . '</CardExpireDateYear>'
            . '<CardExpireDateMonth>' . ($this->cardexpiredatemonth < 10 ? '0' . $this->cardexpiredatemonth : $this->cardexpiredatemonth) . '</CardExpireDateMonth>'
            . '<CardCVV2>' . $this->cardcvv2 . '</CardCVV2>'
            . '<CardHolderName>' . $this->name . '</CardHolderName>'
            . '<CardType>' . $this->cardtype . '</CardType>'
            . '<BatchID>' . $this->batchid . '</BatchID>'
            . '<TransactionType>' . Config::get("TurkeyBank.Type") . '</TransactionType>'
            . '<InstallmentCount>' . $this->InstallmentCount . '</InstallmentCount>'
            . '<Amount>' . $this->amount . '</Amount>'
            . '<DisplayAmount>' . $this->amount . '</DisplayAmount>'
            . '<CurrencyCode>' . Config::get("TurkeyBank.CurrencyCode") . '</CurrencyCode>'
            . '<MerchantOrderId>' . $this->orderid . '</MerchantOrderId>'
            . '<TransactionSecurity>' . Config::get("TurkeyBank.TransactionSecurity") . '</TransactionSecurity>'
            . '<TransactionSide>' . Config::get("TurkeyBank.Type") . '</TransactionSide>'
            . '</KuveytTurkVPosMessage>';
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/xml', 'Content-length: ' . strlen($xml)));
            curl_setopt($ch, CURLOPT_POST, true); //POST Send data using method
            curl_setopt($ch, CURLOPT_HEADER, false); //Don't care about the header information from the server.
            curl_setopt($ch, CURLOPT_URL, Config::get("TurkeyBank.ApiUrl")); //Side URL
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //Get the transfer results.
            $data = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
        echo ($data);
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    }

    public function pay()
    {
        $allvariables = get_object_vars($this);
        foreach ($allvariables as $variables => $key) :
            $this->throwexception($variables, $key);
        endforeach;
        $this->process();
    }

    protected function throwexception($key, $property)
    {
        if (is_null($property)) {
            throw new Exception("" . $key . " field cannot be empty required.", 212);
        }
    }
}
