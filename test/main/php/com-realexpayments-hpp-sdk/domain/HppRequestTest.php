<?php

namespace com\realexpayments\hpp\sdk\domain;
use com\realexpayments\hpp\sdk\SampleJsonData;


/**
 * Tests for HppRequest methods.
 *
 * @author vicpada
 *
 */
class HppRequestTest extends \PHPUnit\Framework\TestCase
{
    const TIMESTAMP = "20130814122239";
    const MERCHANT_ID = "thestore";
    const ORDER_ID = "ORD453-11";
    const AMOUNT = "29900";
    const CURRENCY = "EUR";
    const PAYER_REFERENCE = "newpayer1";
    const PAYMENT_REFERENCE = "mycard1";
    const SELECT_STORED_CARD =  "newpayer1";

    public function  testHash()
    {
        $hppRequest = SampleJsonData::generateValidHppRequest(false);
        $hppRequest->setTimeStamp(self::TIMESTAMP);
        $hppRequest->setMerchantId(self::MERCHANT_ID);
        $hppRequest->setOrderId(self::ORDER_ID);
        $hppRequest->setAmount(self::AMOUNT);
        $hppRequest->setCurrency(self::CURRENCY);

        $expectedHash = "e96eed4869a6d682e8fdbb88703ed81faa58f4df";
        $actualHash = $hppRequest->hash("mysecret")->getHash();

        $this->assertEquals($expectedHash, $actualHash,"Card storage hash does not match expected.");
    }

    
    public function  testHashHppSelectCard()
    {
        $hppRequest = new HppRequest();
        $hppRequest = $hppRequest->addTimeStamp(self::TIMESTAMP)
        ->addMerchantId(self::MERCHANT_ID)
        ->addOrderId(self::ORDER_ID)
        ->addAmount(self::AMOUNT)
        ->addCurrency(self::CURRENCY)
        ->addHppSelectStoredCard(self::SELECT_STORED_CARD);

        $expectedHash = "099b6ef236391d8bdc642488fc5e9c54ac31cd80";
        $actualHash = $hppRequest->hash("mysecret")->getHash();

        $this->assertEquals($expectedHash, $actualHash,"Card storage hash does not match expected.");
    }
    
    public function  testHashHppSelectCardAndPaymentReference()
    {
        $hppRequest = new HppRequest();
        $hppRequest = $hppRequest->addTimeStamp(self::TIMESTAMP)
        ->addMerchantId(self::MERCHANT_ID)
        ->addOrderId(self::ORDER_ID)
        ->addAmount(self::AMOUNT)
        ->addCurrency(self::CURRENCY)
        ->addHppSelectStoredCard(self::SELECT_STORED_CARD)
        ->addPaymentReference(self::PAYMENT_REFERENCE);

        $expectedHash = "4106afc4666c6145b623089b1ad4098846badba2";
        $actualHash = $hppRequest->hash("mysecret")->getHash();

        $this->assertEquals($expectedHash, $actualHash,"Card storage hash does not match expected.");
    }

}


