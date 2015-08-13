<?php


namespace com\realexpayments\hpp\sdk\utils;


use com\realexpayments\hpp\sdk\domain\HppRequest;

class RequestMapper implements iMapper
{

    private static $KNOWN_FIELDS = array('MERCHANT_ID', 'ACCOUNT', 'ORDER_ID', 'AMOUNT', 'CURRENCY', 'TIMESTAMP',
        'SHA1HASH', 'AUTO_SETTLE_FLAG', 'COMMENT1', 'COMMENT2', 'RETURN_TSS', 'SHIPPING_CODE', 'SHIPPING_CO',
        'BILLING_CODE', 'BILLING_CO', 'CUST_NUM', 'VAR_REF', 'PROD_ID', 'HPP_LANG', 'CARD_PAYMENT_BUTTON',
        'CARD_STORAGE_ENABLE', 'OFFER_SAVE_CARD', 'PAYER_REF', 'PMT_REF', 'PAYER_EXIST',
        'VALIDATE_CARD_ONLY', 'DCC_ENABLE');

    /**
     *
     * Receives a domain object and generates a Json string
     *
     * @param HppRequest $hppRequest
     * @return string
     */
    public function  WriteValueAsString($hppRequest)
    {
        $prop = array(
            'MERCHANT_ID' => $hppRequest->getMerchantId(),
            'ACCOUNT' => $hppRequest->getAccount(),
            'ORDER_ID' => $hppRequest->getOrderId(),
            'AMOUNT' => $hppRequest->getAmount(),
            'CURRENCY' => $hppRequest->getCurrency(),
            'TIMESTAMP' => $hppRequest->getTimeStamp(),
            'SHA1HASH' => $hppRequest->getHash(),
            'AUTO_SETTLE_FLAG' => $hppRequest->getAutoSettleFlag(),
            'COMMENT1' => $hppRequest->getCommentOne(),
            'COMMENT2' => $hppRequest->getCommentTwo(),
            'RETURN_TSS' => $hppRequest->getReturnTss(),
            'SHIPPING_CODE' => $hppRequest->getShippingCode(),
            'SHIPPING_CO' => $hppRequest->getShippingCountry(),
            'BILLING_CODE' => $hppRequest->getBillingCode(),
            'BILLING_CO' => $hppRequest->getBillingCountry(),
            'CUST_NUM' => $hppRequest->getCustomerNumber(),
            'VAR_REF' => $hppRequest->getVariableReference(),
            'PROD_ID' => $hppRequest->getProductId(),
            'HPP_LANG' => $hppRequest->getLanguage(),
            'CARD_PAYMENT_BUTTON' => $hppRequest->getCardPaymentButtonText(),
            'CARD_STORAGE_ENABLE' => $hppRequest->getCardStorageEnable(),
            'OFFER_SAVE_CARD' => $hppRequest->getOfferSaveCard(),
            'PAYER_REF' => $hppRequest->getPayerReference(),
            'PMT_REF' => $hppRequest->getPaymentReference(),
            'PAYER_EXIST' => $hppRequest->getPayerExists(),
            'VALIDATE_CARD_ONLY' => $hppRequest->getValidateCardOnly(),
            'DCC_ENABLE' => $hppRequest->getDccEnable()
        );

        foreach ($hppRequest->getSupplementaryData() as $key => $value) {
            $prop[$key] = $value;
        }

        return json_encode($prop);
    }


    /**
     *
     * Receives a Json string and generates a domain object
     *
     * @param string $value
     * @return HppRequest
     */
    public function  ReadValue($value)
    {
        $array = json_decode($value, true);

        if ($array) {

            $hppRequest = new HppRequest();

            $hppRequest->setMerchantId($array['MERCHANT_ID']);
            $hppRequest->setAccount($array['ACCOUNT']);
            $hppRequest->setOrderId($array['ORDER_ID']);
            $hppRequest->setAmount($array['AMOUNT']);
            $hppRequest->setCurrency($array['CURRENCY']);
            $hppRequest->setTimeStamp($array['TIMESTAMP']);
            $hppRequest->setHash($array['SHA1HASH']);
            $hppRequest->setAutoSettleFlag($array['AUTO_SETTLE_FLAG']);
            $hppRequest->setCommentOne($array['COMMENT1']);
            $hppRequest->setCommentTwo($array['COMMENT2']);
            $hppRequest->setReturnTss($array['RETURN_TSS']);
            $hppRequest->setShippingCode($array['SHIPPING_CODE']);
            $hppRequest->setShippingCountry($array['SHIPPING_CO']);
            $hppRequest->setBillingCode($array['BILLING_CODE']);
            $hppRequest->setBillingCountry($array['BILLING_CO']);
            $hppRequest->setCustomerNumber($array['CUST_NUM']);
            $hppRequest->setVariableReference($array['VAR_REF']);
            $hppRequest->setProductId($array['PROD_ID']);
            $hppRequest->setLanguage($array['HPP_LANG']);
            $hppRequest->setCardPaymentButtonText($array['CARD_PAYMENT_BUTTON']);
            $hppRequest->setValidateCardOnly($array['VALIDATE_CARD_ONLY']);
            $hppRequest->setDccEnable($array['DCC_ENABLE']);
            $hppRequest->setCardStorageEnable($array['CARD_STORAGE_ENABLE']);
            $hppRequest->setOfferSaveCard($array['OFFER_SAVE_CARD']);
            $hppRequest->setPayerReference($array['PAYER_REF']);
            $hppRequest->setPaymentReference($array['PMT_REF']);
            $hppRequest->setPayerExists($array['PAYER_EXIST']);

            $supplementaryData = array();

            foreach ($array as $key => $value) {

                if (!$this->isKnownProperty($key)) {
                    $supplementaryData[$key] = $value;
                }
            }

            $hppRequest->setSupplementaryData($supplementaryData);

            return $hppRequest;
        }

        return $array;
    }

    private function isKnownProperty($key)
    {
        return in_array(strtoupper($key), self::$KNOWN_FIELDS);
    }

}