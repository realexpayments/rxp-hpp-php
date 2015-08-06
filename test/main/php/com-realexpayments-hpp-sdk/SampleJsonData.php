<?php


namespace com\realexpayments\hpp\sdk;

use com\realexpayments\hpp\sdk\domain\Flag;
use com\realexpayments\hpp\sdk\domain\HppRequest;

/**
 * Class containing sample JSON data and methods to check test data matches expected values.
 *
 * @author vicpada
 *
 */
class SampleJsonData {
	//sample JSON file paths
	const VALID_HPP_REQUEST_JSON_PATH = "/sample-json/hpp-request-valid.json";
	const VALID_HPP_RESPONSE_JSON_PATH = "/sample-json/hpp-response-valid.json";
	const VALID_HPP_REQUEST_ENCODED_JSON_PATH = "/sample-json/hpp-request-encoded-valid.json";
	const VALID_HPP_RESPONSE_ENCODED_JSON_PATH = "/sample-json/hpp-response-encoded-valid.json";
	const UNKNOWN_DATA_HPP_REQUEST_JSON_PATH = "/sample-json/hpp-request-unknown-data.json";
	const UNKNOWN_DATA_HPP_RESPONSE_JSON_PATH = "/sample-json/hpp-response-unknown-data.json";
	const VALID_HPP_REQUEST_CARD_STORAGE_JSON_PATH = "/sample-json/hpp-request-card-storage.json";

	//valid JSON constants
	const SECRET = "mysecret";
	const ACCOUNT = "myAccount";
	const AMOUNT = 100;
	const COMMENT_ONE = "a-z A-Z 0-9 ' \", + “” ._ - & \\ / @ ! ? % ( )* : £ $ & € # [ ] | = ;ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõö÷ø¤ùúûüýþÿŒŽšœžŸ¥";
	const COMMENT_TWO = "Comment Two";

	//valid JSON constants HppRequest
	const MERCHANT_ID = "MerchantID";
	const TIMESTAMP = "20990101120000";
	//const AUTO_SETTLE_FLAG = Flag.TRUE.getFlag();
	const BILLING_CODE = "123|56";
	const BILLING_COUNTRY = "IRELAND";
	const CARD_PAYMENT_BUTTON_TEXT = "Submit Payment";
	//const CARD_STORAGE_ENABLE = Flag.FALSE.getFlag();
	const CURRENCY = "EUR";
	const CUSTOMER_NUMBER = "123456";
	const HASH_REQUEST = "5d8f05abd618e50db4861a61cc940112786474cf";
	const LANGUAGE = "EN";
	//const OFFER_SAVE_CARD = Flag.FALSE.getFlag();
	const ORDER_ID = "OrderID";
	//const PAYER_EXISTS = Flag.FALSE.getFlag();
	const PAYER_REF = "PayerRef";
	const PAYMENT_REF = "PaymentRef";
	const PRODUCT_ID = "ProductID";
	const RETURN_TSS = Flag::FALSE;
	const SHIPPING_CODE = "56|987";
	const SHIPPING_COUNTRY = "IRELAND";
	const VARIABLE_REFERENCE = "VariableRef";
	const VALIDATE_CARD_ONLY = "0";
	const DCC_ENABLE = "0";

	//valid JSON constants HppResponse
	const ORDER_ID_RESPONSE = "ORD453-11";
	const MERCHANT_ID_RESPONSE = "thestore";
	const AUTH_CODE = "79347";
	const BATCH_ID = "654321";
	const CAVV = "123";
	const CVN_RESULT = "1";
	const ECI = "1";
	const HASH_RESPONSE = "f093a0b233daa15f2bf44888f4fe75cb652e7bf0";
	const MESSAGE = "Successful";
	const PAS_REF = "3737468273643";
	const RESULT = "00";
	const XID = "654564564";
//public static final Map<String, String> TSS = generateTssResult();
	const TSS_ONE_KEY = "TSS_1";
	const TSS_ONE_VALUE = "TSS_1_VALUE";
	const TSS_TWO_KEY = "TSS_2";
	const TSS_TWO_VALUE = "TSS_2_VALUE";
	const TIMESTAMP_RESPONSE = "20130814122239";

	//supplementary data (unknown values)
	const UNKNOWN_ONE_KEY = "UNKNOWN_1";
	const UNKNOWN_ONE_VALUE = "Unknown value 1";
	const UNKNOWN_TWO_KEY = "UNKNOWN_2";
	const UNKNOWN_TWO_VALUE = "Unknown value 2";
	const UNKNOWN_THREE_KEY = "UNKNOWN_3";
	const UNKNOWN_THREE_VALUE = "Unknown value 3";
	const UNKNOWN_FOUR_KEY = "UNKNOWN_4";
	const UNKNOWN_FOUR_VALUE = "Unknown value 4";
	private static $SUPPLEMENTARY_DATA;// = generateSupplementaryData();


	/**
	 * Generates {@link HppRequest} object.
	 *
	 * @param bool $cardStorage
	 *
	 * @return HppRequest
	 */
	public static function generateValidHppRequest( $cardStorage ) {
		$hppRequest = self::generateValidHppRequestWithEmptyDefaults( $cardStorage )
		                  ->addHash( self::HASH_REQUEST )
		                  ->addOrderId( self::ORDER_ID )
		                  ->addTimeStamp( self::TIMESTAMP );

		return $hppRequest;

	}

	/**
	 * Generates {@link HppRequest} object with empty defaults (time stamp and order ID).
	 *
	 * @param bool $cardStorage
	 *
	 * @return HppRequest
	 */
	public static function generateValidHppRequestWithEmptyDefaults( $cardStorage ) {
		// TODO: Fill Real Vault on next iteration

		$hppRequest = new HppRequest();
		$hppRequest->addAccount( self::ACCOUNT )
		           ->addAmount( self::AMOUNT )
		           ->addAutoSettleFlag( Flag::TRUE )
		           ->addBillingCode( self::BILLING_CODE )
		           ->addBillingCountry( self::BILLING_COUNTRY )
		           ->addCardPaymentButtonText( self::CARD_PAYMENT_BUTTON_TEXT )
			//->addCardStorageEnable(self::CARD_STORAGE_ENABLE->equals(self::Flag->TRUE->getFlag(self::)))
			       ->addCommentOne( self::COMMENT_ONE )
		           ->addCommentTwo( self::COMMENT_TWO )
		           ->addCurrency( self::CURRENCY )
		           ->addCustomerNumber( self::CUSTOMER_NUMBER )
		           ->addLanguage( self::LANGUAGE )
		           ->addMerchantId( self::MERCHANT_ID )
			//->addOfferSaveCard(self::OFFER_SAVE_CARD->equals(self::Flag->TRUE->getFlag(self::)))
			//->addPayerExists(self::PAYER_EXISTS->equals(self::Flag->TRUE->getFlag(self::)))
			//->addPayerReference(self::PAYER_REF)
			//->addPaymentReference(self::PAYMENT_REF)
			       ->addProductId( self::PRODUCT_ID )
		           ->addReturnTss( self::RETURN_TSS )
		           ->addShippingCode( self::SHIPPING_CODE )
		           ->addShippingCountry( self::SHIPPING_COUNTRY )
		           ->addVariableReference( self::VARIABLE_REFERENCE )
		           ->addValidateCardOnly( self::VALIDATE_CARD_ONLY )
		           ->addDccEnable( self::DCC_ENABLE );

		/*
		 if ($cardStorage) {
			hppRequest.setCardStorageEnable(Flag::TRUE);
			hppRequest.setOfferSaveCard(Flag::TRUE);
		}
		 */

		$hppRequest->setSupplementaryData( self::$SUPPLEMENTARY_DATA );

		return $hppRequest;
	}


	static function Init() {
		self::$SUPPLEMENTARY_DATA = self::generateSupplementaryData();
	}

	/**
	 * Generate map of supplementary data.
	 * @return array
	 */
	public static function generateSupplementaryData() {

		$data                            = array();
		$data[ self::UNKNOWN_ONE_KEY ]   = self::UNKNOWN_ONE_VALUE;
		$data[ self::UNKNOWN_TWO_KEY ]   = self::UNKNOWN_TWO_VALUE;
		$data[ self::UNKNOWN_THREE_KEY ] = self::UNKNOWN_THREE_VALUE;
		$data[ self::UNKNOWN_FOUR_KEY ]  = self::UNKNOWN_FOUR_VALUE;

		return $data;
	}
}

SampleJsonData::Init();