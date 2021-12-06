<?php


namespace com\realexpayments\hpp\sdk\utils;


use com\realexpayments\hpp\sdk\domain\HppRequest;

class RequestMapper implements iMapper {

	private static $KNOWN_FIELDS = array(
		'MERCHANT_ID',
		'ACCOUNT',
		'ORDER_ID',
		'AMOUNT',
		'CURRENCY',
		'TIMESTAMP',
		'SHA1HASH',
		'AUTO_SETTLE_FLAG',
		'COMMENT1',
		'COMMENT2',
		'RETURN_TSS',
		'SHIPPING_CODE',
		'SHIPPING_CO',
		'BILLING_CODE',
		'BILLING_CO',
		'CUST_NUM',
		'VAR_REF',
		'PROD_ID',
		'HPP_LANG',
		'CARD_PAYMENT_BUTTON',
		'CARD_STORAGE_ENABLE',
		'OFFER_SAVE_CARD',
		'PAYER_REF',
		'PMT_REF',
		'PAYER_EXIST',
		'VALIDATE_CARD_ONLY',
		'DCC_ENABLE',
		'HPP_VERSION',
		'HPP_SELECT_STORED_CARD',
		'HPP_POST_DIMENSIONS',
		'HPP_POST_RESPONSE',
		'HPP_CUSTOMER_EMAIL',
		'HPP_CUSTOMER_PHONENUMBER_MOBILE',
		'HPP_BILLING_STREET1',
		'HPP_BILLING_STREET2',
		'HPP_BILLING_STREET3',
		'HPP_BILLING_CITY',
		'HPP_BILLING_STATE',
		'HPP_BILLING_POSTALCODE',
		'HPP_BILLING_COUNTRY',
		'HPP_SHIPPING_STREET1',
		'HPP_SHIPPING_STREET2',
		'HPP_SHIPPING_STREET3',
		'HPP_SHIPPING_CITY',
		'HPP_SHIPPING_STATE',
		'HPP_SHIPPING_POSTALCODE',
		'HPP_SHIPPING_COUNTRY',
		'HPP_ADDRESS_MATCH_INDICATOR',
		'HPP_CHALLENGE_REQUEST_INDICATOR',
	);

	/**
	 *
	 * Receives a domain object and generates a Json string
	 *
	 * @param HppRequest $hppRequest
	 *
	 * @return string
	 */
	public function  WriteValueAsString( $hppRequest ) {
		$prop = array(
			'MERCHANT_ID'         => $hppRequest->getMerchantId(),
			'ACCOUNT'             => $hppRequest->getAccount(),
			'ORDER_ID'            => $hppRequest->getOrderId(),
			'AMOUNT'              => $hppRequest->getAmount(),
			'CURRENCY'            => $hppRequest->getCurrency(),
			'TIMESTAMP'           => $hppRequest->getTimeStamp(),
			'SHA1HASH'            => $hppRequest->getHash(),
			'AUTO_SETTLE_FLAG'    => $hppRequest->getAutoSettleFlag(),
			'COMMENT1'            => $hppRequest->getCommentOne(),
			'COMMENT2'            => $hppRequest->getCommentTwo(),
			'RETURN_TSS'          => $hppRequest->getReturnTss(),
			'SHIPPING_CODE'       => $hppRequest->getShippingCode(),
			'SHIPPING_CO'         => $hppRequest->getShippingCountry(),
			'BILLING_CODE'        => $hppRequest->getBillingCode(),
			'BILLING_CO'          => $hppRequest->getBillingCountry(),
			'CUST_NUM'            => $hppRequest->getCustomerNumber(),
			'VAR_REF'             => $hppRequest->getVariableReference(),
			'PROD_ID'             => $hppRequest->getProductId(),
			'HPP_LANG'            => $hppRequest->getLanguage(),
			'CARD_PAYMENT_BUTTON' => $hppRequest->getCardPaymentButtonText(),
			'CARD_STORAGE_ENABLE' => $hppRequest->getCardStorageEnable(),
			'OFFER_SAVE_CARD'     => $hppRequest->getOfferSaveCard(),
			'PAYER_REF'           => $hppRequest->getPayerReference(),
			'PMT_REF'             => $hppRequest->getPaymentReference(),
			'PAYER_EXIST'         => $hppRequest->getPayerExists(),
			'VALIDATE_CARD_ONLY'  => $hppRequest->getValidateCardOnly(),
			'DCC_ENABLE'          => $hppRequest->getDccEnable()
		);

		$supplementaryData = $hppRequest->getSupplementaryData();

		if ( is_array( $supplementaryData ) ) {
			foreach ( $supplementaryData as $key => $value ) {
				$prop[ $key ] = $value;
			}
		}

		if($hppRequest->getHppVersion() != null)
			$prop['HPP_VERSION'] = $hppRequest->getHppVersion();

		if($hppRequest->getHppSelectStoredCard() != null)
			$prop['HPP_SELECT_STORED_CARD'] = $hppRequest->getHppSelectStoredCard();

		if($hppRequest->getPostDimensions() != null)
			$prop['HPP_POST_DIMENSIONS'] = $hppRequest->getPostDimensions();

		if($hppRequest->getPostResponse() != null)
			$prop['HPP_POST_RESPONSE'] = $hppRequest->getPostResponse();

		if ($hppRequest->getCustomerEmailAddress() != null) {
			$prop['HPP_CUSTOMER_EMAIL'] = $hppRequest->getCustomerEmailAddress();
		}

		if ($hppRequest->getCustomerMobilePhoneNumber() != null) {
			$prop['HPP_CUSTOMER_PHONENUMBER_MOBILE'] = $hppRequest->getCustomerMobilePhoneNumber();
		}

		if ($hppRequest->getBillingAddressLine1() != null) {
			$prop['HPP_BILLING_STREET1'] = $hppRequest->getBillingAddressLine1();
		}

		if ($hppRequest->getBillingAddressLine2() != null) {
			$prop['HPP_BILLING_STREET2'] = $hppRequest->getBillingAddressLine2();
		}

		if ($hppRequest->getBillingAddressLine3() != null) {
			$prop['HPP_BILLING_STREET3'] = $hppRequest->getBillingAddressLine3();
		}

		if ($hppRequest->getBillingCity() != null) {
			$prop['HPP_BILLING_CITY'] = $hppRequest->getBillingCity();
		}

		if ($hppRequest->getBillingState() != null) {
			$prop['HPP_BILLING_STATE'] = $hppRequest->getBillingState();
		}

		if ($hppRequest->getBillingPostalCode() != null) {
			$prop['HPP_BILLING_POSTALCODE'] = $hppRequest->getBillingPostalCode();
		}

		if ($hppRequest->getBillingCountryCode() != null) {
			$prop['HPP_BILLING_COUNTRY'] = $hppRequest->getBillingCountryCode();
		}

		if ($hppRequest->getShippingAddressLine1() != null) {
			$prop['HPP_SHIPPING_STREET1'] = $hppRequest->getShippingAddressLine1();
		}

		if ($hppRequest->getShippingAddressLine2() != null) {
			$prop['HPP_SHIPPING_STREET2'] = $hppRequest->getShippingAddressLine2();
		}

		if ($hppRequest->getShippingAddressLine3() != null) {
			$prop['HPP_SHIPPING_STREET3'] = $hppRequest->getShippingAddressLine3();
		}

		if ($hppRequest->getShippingCity() != null) {
			$prop['HPP_SHIPPING_CITY'] = $hppRequest->getShippingCity();
		}

		if ($hppRequest->getShippingState() != null) {
			$prop['HPP_SHIPPING_STATE'] = $hppRequest->getShippingState();
		}

		if ($hppRequest->getShippingPostalCode() != null) {
			$prop['HPP_SHIPPING_POSTALCODE'] = $hppRequest->getShippingPostalCode();
		}

		if ($hppRequest->getShippingCountryCode() != null) {
			$prop['HPP_SHIPPING_COUNTRY'] = $hppRequest->getShippingCountryCode();
		}

		if ($hppRequest->getShippingAddressMatchIndicator() != null) {
			$prop['HPP_ADDRESS_MATCH_INDICATOR'] = $hppRequest->getShippingAddressMatchIndicator() ? 'TRUE' : 'FALSE';
		}

		if ($hppRequest->getChallengeRequestIndicator() != null) {
			$prop['HPP_CHALLENGE_REQUEST_INDICATOR'] = $hppRequest->getChallengeRequestIndicator();
		}

		return json_encode( $prop );
	}


	/**
	 *
	 * Receives a Json string and generates a domain object
	 *
	 * @param string $value
	 *
	 * @return HppRequest
	 */
	public function  ReadValue( $value ) {
		$array = json_decode( $value, true );
		$array = new SafeArrayAccess( $array, "" );

		if ( $array ) {

			$hppRequest = new HppRequest();

			$hppRequest->setMerchantId( $array['MERCHANT_ID'] );
			$hppRequest->setAccount( $array['ACCOUNT'] );
			$hppRequest->setOrderId( $array['ORDER_ID'] );
			$hppRequest->setAmount( $array['AMOUNT'] );
			$hppRequest->setCurrency( $array['CURRENCY'] );
			$hppRequest->setTimeStamp( $array['TIMESTAMP'] );
			$hppRequest->setHash( $array['SHA1HASH'] );
			$hppRequest->setAutoSettleFlag( $array['AUTO_SETTLE_FLAG'] );
			$hppRequest->setCommentOne( $array['COMMENT1'] );
			$hppRequest->setCommentTwo( $array['COMMENT2'] );
			$hppRequest->setReturnTss( $array['RETURN_TSS'] );
			$hppRequest->setShippingCode( $array['SHIPPING_CODE'] );
			$hppRequest->setShippingCountry( $array['SHIPPING_CO'] );
			$hppRequest->setBillingCode( $array['BILLING_CODE'] );
			$hppRequest->setBillingCountry( $array['BILLING_CO'] );
			$hppRequest->setCustomerNumber( $array['CUST_NUM'] );
			$hppRequest->setVariableReference( $array['VAR_REF'] );
			$hppRequest->setProductId( $array['PROD_ID'] );
			$hppRequest->setLanguage( $array['HPP_LANG'] );
			$hppRequest->setCardPaymentButtonText( $array['CARD_PAYMENT_BUTTON'] );
			$hppRequest->setValidateCardOnly( $array['VALIDATE_CARD_ONLY'] );
			$hppRequest->setDccEnable( $array['DCC_ENABLE'] );
			$hppRequest->setCardStorageEnable( $array['CARD_STORAGE_ENABLE'] );
			$hppRequest->setOfferSaveCard( $array['OFFER_SAVE_CARD'] );
			$hppRequest->setPayerReference( $array['PAYER_REF'] );
			$hppRequest->setPaymentReference( $array['PMT_REF'] );
			$hppRequest->setPayerExists( $array['PAYER_EXIST'] );
			$hppRequest->setHppVersion( $array['HPP_VERSION'] );
			$hppRequest->setHppSelectStoredCard( $array['HPP_SELECT_STORED_CARD'] );
			$hppRequest->setPostDimensions( $array['HPP_POST_DIMENSIONS'] );
			$hppRequest->setPostResponse( $array['HPP_POST_RESPONSE'] );
			$hppRequest->setCustomerEmailAddress( $array['HPP_CUSTOMER_EMAIL'] );
			$hppRequest->setCustomerMobilePhoneNumber( $array['HPP_CUSTOMER_PHONENUMBER_MOBILE'] );
			$hppRequest->setBillingAddressLine1( $array['HPP_BILLING_STREET1'] );
			$hppRequest->setBillingAddressLine2( $array['HPP_BILLING_STREET2'] );
			$hppRequest->setBillingAddressLine3( $array['HPP_BILLING_STREET3'] );
			$hppRequest->setBillingCity( $array['HPP_BILLING_CITY'] );
			$hppRequest->setBillingState( $array['HPP_BILLING_STATE'] );
			$hppRequest->setBillingPostalCode( $array['HPP_BILLING_POSTALCODE'] );
			$hppRequest->setBillingCountryCode( $array['HPP_BILLING_COUNTRY'] );
			$hppRequest->setShippingAddressLine1( $array['HPP_SHIPPING_STREET1'] );
			$hppRequest->setShippingAddressLine2( $array['HPP_SHIPPING_STREET2'] );
			$hppRequest->setShippingAddressLine3( $array['HPP_SHIPPING_STREET3'] );
			$hppRequest->setShippingCity( $array['HPP_SHIPPING_CITY'] );
			$hppRequest->setShippingState( $array['HPP_SHIPPING_STATE'] );
			$hppRequest->setShippingPostalCode( $array['HPP_SHIPPING_POSTALCODE'] );
			$hppRequest->setShippingCountryCode( $array['HPP_SHIPPING_COUNTRY'] );
			$hppRequest->setShippingAddressMatchIndicator( $array['HPP_ADDRESS_MATCH_INDICATOR'] );
			$hppRequest->setChallengeRequestIndicator( $array['HPP_CHALLENGE_REQUEST_INDICATOR'] );

			$supplementaryData = array();

			foreach ( $array->getUnderLayingArray() as $key => $value ) {

				if ( ! $this->isKnownProperty( $key ) ) {
					$supplementaryData[ $key ] = $value;
				}
			}

			$hppRequest->setSupplementaryData( $supplementaryData );


			return $hppRequest;
		}

		return $array;
	}

	private function isKnownProperty( $key ) {
		return in_array( strtoupper( $key ), self::$KNOWN_FIELDS );
	}


}