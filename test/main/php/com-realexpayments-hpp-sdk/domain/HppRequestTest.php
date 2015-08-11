<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 11/08/2015
 * Time: 16:08
 */

namespace com\realexpayments\hpp\sdk\domain;
use com\realexpayments\hpp\sdk\SampleJsonData;


/**
 * Tests for HppRequest methods.
 *
 * @author vicpada
 *
 */
class HppRequestTest extends \PHPUnit_Framework_TestCase
{
    const TIMESTAMP = "20130814122239";
    const MERCHANT_ID = "thestore";
    const ORDER_ID = "ORD453-11";
    const AMOUNT = "29900";
    const CURRENCY = "EUR";
    const PAYER_REFERENCE = "newpayer1";
    const PAYMENT_REFERENCE = "mycard1";

    public function  testHash()
    {
        $hppRequest = SampleJsonData::generateValidHppRequest(false);
        $hppRequest->setTimeStamp(self::TIMESTAMP);
        $hppRequest->setMerchantId(self::MERCHANT_ID);
        $hppRequest->setOrderId(self::ORDER_ID);
        $hppRequest->setAmount(self::AMOUNT);
        $hppRequest->setCurrency(self::CURRENCY);

        $expectedHash = "cc72c08e529b3bc153481eda9533b815cef29de3";
        $actualHash = $hppRequest->hash("mysecret")->getHash();

        $this->assertEquals($expectedHash, $actualHash,"Card storage hash does not match expected.");
    }

    /*
     * TODO: Next iteration: cardStoreHashTest
     */

}


