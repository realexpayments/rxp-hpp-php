<?php


namespace com\realexpayments\hpp\sdk\domain;

use com\realexpayments\hpp\sdk\utils\GenerationUtils;
use Exception;


/**
 * Class representing the HPP response.
 * @package com\realexpayments\hpp\sdk\domain
 * @author vicpada
 */
class HppResponse {


	/**
	 * @var string This is the merchant id that Realex Payments assign to you.
	 */
	private $merchantId;

	/**
	 * @var string The sub-account used in the transaction.
	 */
	private $account;

	/**
	 * @var string The unique order id that you sent to us.
	 */
	private $orderId;

	/**
	 * @var string The amount that was authorised. Returned in the lowest unit of the currency.
	 */
	private $amount;

	/**
	 * @var string Will contain a valid authcode if the transaction was successful. Will be empty otherwise.
	 */
	private $authCode;

	/**
	 * @var string The date and time of the transaction.
	 */
	private $timeStamp;

	/**
	 * @var string A SHA-1 digital signature created using the HPP response fields and your shared secret.
	 */
	private $hash;

	/**
	 * @var string The outcome of the transaction. Will contain "00" if the transaction was a success
	 * or another value (depending on the error) if not.
	 */
	private $result;

	/**
	 * @var string Will contain a text message that describes the result code.
	 */
	private $message;


	/**
	 * <p>
	 * The result of the Card Verification check (if enabled):
	 * <ul>
	 * <li>M: CVV Matched.</li>
	 * <li>N: CVV Not Matched.</li>
	 * <li>I: CVV Not checked due to circumstances.</li>
	 * <li>U: CVV Not checked - issuer not certified.</li>
	 * <li>P: CVV Not Processed.</li>
	 * </ul>
	 * </p>
	 *
	 * @var string cvn result
	 */
	private $cvnResult;

	/**
	 * @var string A unique reference that Realex Payments assign to your transaction.
	 */
	private $pasRef;

	/**
	 * @var string This is the Realex Payments batch that this transaction will be in.
	 * (This is equal to "-1" if the transaction was sent in with the autosettle flag off.
	 * After you settle it (either manually or programmatically) the response to that transaction
	 * will contain the batch id.)
	 */
	private $batchId;

	/**
	 * @var string This is the ecommerce indicator (this will only be returned for 3DSecure transactions).
	 */
	private $eci;

	/**
	 * @var string Cardholder Authentication Verification Value (this will only be returned for 3DSecure transactions).
	 */
	private $cavv;

	/**
	 * @var string Exchange Identifier (this will only be returned for 3DSecure transactions).
	 */
	private $xid;

	/**
	 * @var string Whatever data you have sent in the request will be returned to you.
	 */
	private $commentOne;

	/**
	 * @var string Whatever data you have sent in the request will be returned to you.
	 */
	private $commentTwo;

	/**
	 * The Transaction Suitability Score for the transaction. The RealScore is comprised of various distinct tests.
	 * Using the RealControl application you can request that Realex Payments return certain individual scores to you.
	 * These are identified by numbers - thus TSS_1032 would be the result of the check with id 1032.
	 * You can then use these specific checks in conjunction with RealScore score to ascertain whether
	 * or not you wish to continue with the settlement.
	 *
	 * @var array TSS
	 */
	private $tss = array();

	/**
	 *
	 * Anything else you sent to us in the request will be returned to you in supplementary data.
	 *
	 * @var array Supplementary data
	 */
	private $supplementaryData = array();

	/**
	 * @var string Address Verification Service result for cardholder address
	 */
	private $AVSAddressResult;

	/**
	 * @var string Address Verification Service result for cardholder billing code
	 */
	private $AVSPostCodeResult;


	/**
	 * HppResponse constructor.
	 */
	public function __construct() {
	}

	/**
	 * Getter for merchantId
	 *
	 * @return string
	 */
	public function getMerchantId() {
		return $this->merchantId;
	}

	/**
	 * Setter for merchantId
	 *
	 * @param string $merchantId
	 */
	public function setMerchantId( $merchantId ) {
		$this->merchantId = $merchantId;
	}

	/**
	 * Getter for account
	 *
	 * @return string
	 */
	public function getAccount() {
		return $this->account;
	}

	/**
	 * Setter for account
	 *
	 * @param string $account
	 */
	public function setAccount( $account ) {
		$this->account = $account;
	}

	/**
	 * Getter for orderId
	 *
	 * @return string
	 */
	public function getOrderId() {
		return $this->orderId;
	}

	/**
	 * Setter for orderId
	 *
	 * @param string $orderId
	 */
	public function setOrderId( $orderId ) {
		$this->orderId = $orderId;
	}

	/**
	 * Getter for amount
	 *
	 * @return string
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * Setter for amount
	 *
	 * @param string $amount
	 */
	public function setAmount( $amount ) {
		$this->amount = $amount;
	}

	/**
	 * Getter for authCode
	 *
	 * @return string
	 */
	public function getAuthCode() {
		return $this->authCode;
	}

	/**
	 * Setter for authCode
	 *
	 * @param string $authCode
	 */
	public function setAuthCode( $authCode ) {
		$this->authCode = $authCode;
	}

	/**
	 * Getter for timeStamp
	 *
	 * @return string
	 */
	public function getTimeStamp() {
		return $this->timeStamp;
	}

	/**
	 * Setter for timeStamp
	 *
	 * @param string $timeStamp
	 */
	public function setTimeStamp( $timeStamp ) {
		$this->timeStamp = $timeStamp;
	}

	/**
	 * Getter for hash
	 *
	 * @return string
	 */
	public function getHash() {
		return $this->hash;
	}

	/**
	 * Setter for hash
	 *
	 * @param string $hash
	 */
	public function setHash( $hash ) {
		$this->hash = $hash;
	}

	/**
	 * Getter for result
	 *
	 * @return string
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * Setter for result
	 *
	 * @param string $result
	 */
	public function setResult( $result ) {
		$this->result = $result;
	}

	/**
	 * Getter for message
	 *
	 * @return string
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * Setter for message
	 *
	 * @param string $message
	 */
	public function setMessage( $message ) {
		$this->message = $message;
	}

	/**
	 * Getter for cvnResult
	 *
	 * @return string
	 */
	public function getCvnResult() {
		return $this->cvnResult;
	}

	/**
	 * Setter for cvnResult
	 *
	 * @param string $cvnResult
	 */
	public function setCvnResult( $cvnResult ) {
		$this->cvnResult = $cvnResult;
	}

	/**
	 * Getter for pasRef
	 *
	 * @return string
	 */
	public function getPasRef() {
		return $this->pasRef;
	}

	/**
	 * Setter for pasRef
	 *
	 * @param string $pasRef
	 */
	public function setPasRef( $pasRef ) {
		$this->pasRef = $pasRef;
	}

	/**
	 * Getter for batchId
	 *
	 * @return string
	 */
	public function getBatchId() {
		return $this->batchId;
	}

	/**
	 * Setter for batchId
	 *
	 * @param string $batchId
	 */
	public function setBatchId( $batchId ) {
		$this->batchId = $batchId;
	}

	/**
	 * Getter for eci
	 *
	 * @return string
	 */
	public function getEci() {
		return $this->eci;
	}

	/**
	 * Setter for eci
	 *
	 * @param string $eci
	 */
	public function setEci( $eci ) {
		$this->eci = $eci;
	}

	/**
	 * Getter for cavv
	 *
	 * @return string
	 */
	public function getCavv() {
		return $this->cavv;
	}

	/**
	 * Setter for cavv
	 *
	 * @param string $cavv
	 */
	public function setCavv( $cavv ) {
		$this->cavv = $cavv;
	}

	/**
	 * Getter for xid
	 *
	 * @return string
	 */
	public function getXid() {
		return $this->xid;
	}

	/**
	 * Setter for xid
	 *
	 * @param string $xid
	 */
	public function setXid( $xid ) {
		$this->xid = $xid;
	}

	/**
	 * Getter for commentOne
	 *
	 * @return string
	 */
	public function getCommentOne() {
		return $this->commentOne;
	}

	/**
	 * Setter for commentOne
	 *
	 * @param string $commentOne
	 */
	public function setCommentOne( $commentOne ) {
		$this->commentOne = $commentOne;
	}

	/**
	 * Getter for commentTwo
	 *
	 * @return string
	 */
	public function getCommentTwo() {
		return $this->commentTwo;
	}

	/**
	 * Setter for commentTwo
	 *
	 * @param string $commentTwo
	 */
	public function setCommentTwo( $commentTwo ) {
		$this->commentTwo = $commentTwo;
	}

	/**
	 * Getter for tss
	 *
	 * @return array
	 */
	public function getTss() {
		return $this->tss;
	}

	/**
	 * Setter for tss
	 *
	 * @param array $tss
	 */
	public function setTss( $tss ) {
		$this->tss = $tss;
	}

	/**
	 * Getter for supplementaryData
	 *
	 * @return array
	 */
	public function getSupplementaryData() {
		return $this->supplementaryData;
	}

	/**
	 * Setter for supplementaryData
	 *
	 * @param string $name
	 * @param string $value
	 */
	public function setSupplementaryDataValue( $name, $value ) {
		$this->supplementaryData[ $name ] = $value;
	}

	/**
	 * Getter for AVSAddressResult
	 *
	 * @return string
	 */
	public function getAVSAddressResult() {
		return $this->AVSAddressResult;
	}

	/**
	 * Setter for AVSAddressResult
	 *
	 * @param string $AVSAddressResult
	 */
	public function setAVSAddressResult( $AVSAddressResult ) {
		$this->AVSAddressResult = $AVSAddressResult;
	}

	/**
	 * Getter for AVSPostCodeResult
	 *
	 * @return string
	 */
	public function getAVSPostCodeResult() {
		return $this->AVSPostCodeResult;
	}

	/**
	 * Setter for AVSPostCodeResult
	 *
	 * @param string $AVSPostCodeResult
	 */
	public function setAVSPostCodeResult( $AVSPostCodeResult ) {
		$this->AVSPostCodeResult = $AVSPostCodeResult;
	}


	/**
	 * Helper method for adding a merchantId
	 *
	 * @param string $merchantId
	 *
	 * @return HppResponse
	 */
	public function addMerchantId( $merchantId ) {
		$this->merchantId = $merchantId;

		return $this;
	}

	/**
	 * Helper method for adding a account
	 *
	 * @param string $account
	 *
	 * @return HppResponse
	 */
	public function addAccount( $account ) {
		$this->account = $account;

		return $this;
	}

	/**
	 * Helper method for adding a orderId
	 *
	 * @param string $orderId
	 *
	 * @return HppResponse
	 */
	public function addOrderId( $orderId ) {
		$this->orderId = $orderId;

		return $this;
	}

	/**
	 * Helper method for adding a amount
	 *
	 * @param string $amount
	 *
	 * @return HppResponse
	 */
	public function addAmount( $amount ) {
		$this->amount = $amount;

		return $this;
	}

	/**
	 * Helper method for adding a authCode
	 *
	 * @param string $authCode
	 *
	 * @return HppResponse
	 */
	public function addAuthCode( $authCode ) {
		$this->authCode = $authCode;

		return $this;
	}

	/**
	 * Helper method for adding a timeStamp
	 *
	 * @param string $timeStamp
	 *
	 * @return HppResponse
	 */
	public function addTimeStamp( $timeStamp ) {
		$this->timeStamp = $timeStamp;

		return $this;
	}

	/**
	 * Helper method for adding a hash
	 *
	 * @param string $hash
	 *
	 * @return HppResponse
	 */
	public function addHash( $hash ) {
		$this->hash = $hash;

		return $this;
	}

	/**
	 * Helper method for adding a result
	 *
	 * @param string $result
	 *
	 * @return HppResponse
	 */
	public function addResult( $result ) {
		$this->result = $result;

		return $this;
	}

	/**
	 * Helper method for adding a message
	 *
	 * @param string $message
	 *
	 * @return HppResponse
	 */
	public function addMessage( $message ) {
		$this->message = $message;

		return $this;
	}

	/**
	 * Helper method for adding a cvnResult
	 *
	 * @param string $cvnResult
	 *
	 * @return HppResponse
	 */
	public function addCvnResult( $cvnResult ) {
		$this->cvnResult = $cvnResult;

		return $this;
	}

	/**
	 * Helper method for adding a pasRef
	 *
	 * @param string $pasRef
	 *
	 * @return HppResponse
	 */
	public function addPasRef( $pasRef ) {
		$this->pasRef = $pasRef;

		return $this;
	}

	/**
	 * Helper method for adding a batchId
	 *
	 * @param string $batchId
	 *
	 * @return HppResponse
	 */
	public function addBatchId( $batchId ) {
		$this->batchId = $batchId;

		return $this;
	}

	/**
	 * Helper method for adding a eci
	 *
	 * @param string $eci
	 *
	 * @return HppResponse
	 */
	public function addEci( $eci ) {
		$this->eci = $eci;

		return $this;
	}

	/**
	 * Helper method for adding a cavv
	 *
	 * @param string $cavv
	 *
	 * @return HppResponse
	 */
	public function addCavv( $cavv ) {
		$this->cavv = $cavv;

		return $this;
	}

	/**
	 * Helper method for adding a xid
	 *
	 * @param string $xid
	 *
	 * @return HppResponse
	 */
	public function addXid( $xid ) {
		$this->xid = $xid;

		return $this;
	}

	/**
	 * Helper method for adding a commentOne
	 *
	 * @param string $commentOne
	 *
	 * @return HppResponse
	 */
	public function addCommentOne( $commentOne ) {
		$this->commentOne = $commentOne;

		return $this;
	}

	/**
	 * Helper method for adding a commentTwo
	 *
	 * @param string $commentTwo
	 *
	 * @return HppResponse
	 */
	public function addCommentTwo( $commentTwo ) {
		$this->commentTwo = $commentTwo;

		return $this;
	}

	/**
	 * Helper method for adding a AVSAddressResult
	 *
	 * @param string $AVSAddressResult
	 *
	 * @return HppResponse
	 */
	public function addAVSAddressResult( $AVSAddressResult ) {
		$this->AVSAddressResult = $AVSAddressResult;

		return $this;
	}

	/**
	 * Helper method for adding a AVSPostCodeResult
	 *
	 * @param string $AVSPostCodeResult
	 *
	 * @return HppResponse
	 */
	public function addAVSPostCodeResult( $AVSPostCodeResult ) {
		$this->AVSPostCodeResult = $AVSPostCodeResult;

		return $this;
	}


	/**
	 * Helper method for adding a tss
	 *
	 * @param array $tss
	 *
	 * @return HppResponse
	 */
	public function addTss( $tss ) {
		$this->tss = $tss;

		return $this;
	}


	/**
	 * @return string The class name
	 */
	public static function GetClassName() {
		return __CLASS__;
	}

	public function hash( $secret ) {
		$this->hash = $this->generateHash( $secret );

		return $this;
	}

	/**
	 * Creates the security hash from a number of fields and the shared secret.
	 *
	 * @param string $secret
	 *
	 * @return String
	 */
	public function generateHash( $secret ) {
		//check for any null values and set them to empty string for hashing
		$timeStamp  = null == $this->timeStamp ? "" : $this->timeStamp;
		$merchantId = null == $this->merchantId ? "" : $this->merchantId;
		$orderId    = null == $this->orderId ? "" : $this->orderId;
		$result     = null == $this->result ? "" : $this->result;
		$message    = null == $this->message ? "" : $this->message;
		$pasRef     = null == $this->pasRef ? "" : $this->pasRef;
		$authCode   = null == $this->authCode ? "" : $this->authCode;

		//create $to hash
		$toHash = $timeStamp
		          . "."
		          . $merchantId
		          . "."
		          . $orderId
		          . "."
		          . $result
		          . "."
		          . $message
		          . "."
		          . $pasRef
		          . "."
		          . $authCode;


		return GenerationUtils::generateHash( $toHash, $secret );
	}

	/**
	 * Helper method to determine if the HPP response security hash is valid.
	 *
	 * @param string $secret
	 *
	 * @return bool
	 */
	public function isHashValid( $secret ) {
		$generatedHash = $this->generateHash( $secret );

		return $generatedHash == $this->hash;
	}

	/**
	 * Base64 encodes the HPP response values.
	 *
	 * @param string $charset
	 *
	 * @return HppResponse
	 * @throws Exception
	 */
	public function encode( $charset ) {
		$this->merchantId         = base64_encode( $this->merchantId );
		$this->account            = base64_encode( $this->account );
		$this->amount             = base64_encode( $this->amount );
		$this->authCode           = base64_encode( $this->authCode );
		$this->batchId            = base64_encode( $this->batchId );
		$this->cavv               = base64_encode( $this->cavv );
		$this->cvnResult          = base64_encode( $this->cvnResult );
		$this->eci                = base64_encode( $this->eci );
		$this->commentOne         = base64_encode( $this->commentOne );
		$this->commentTwo         = base64_encode( $this->commentTwo );
		$this->message            = base64_encode( $this->message );
		$this->pasRef             = base64_encode( $this->pasRef );
		$this->hash               = base64_encode( $this->hash );
		$this->result             = base64_encode( $this->result );
		$this->xid                = base64_encode( $this->xid );
		$this->orderId            = base64_encode( $this->orderId );
		$this->timeStamp          = base64_encode( $this->timeStamp );
		$this->AVSAddressResult   = base64_encode( $this->AVSAddressResult );
		$this->AVSPostCodeResult = base64_encode( $this->AVSPostCodeResult );

		foreach ( $this->tss as $key => $value ) {
			$this->tss[ $key ] = base64_encode( $value );
		}
		foreach ( $this->supplementaryData as $key => $value ) {
			$this->supplementaryData[ $key ] = base64_encode( $value );
		}

		return $this;
	}

	/**
	 * Base64 decodes the HPP response values.
	 *
	 * @param string $charset
	 *
	 * @return HppResponse
	 * @throws Exception
	 */
	public function decode( $charset ) {
		$this->merchantId         = base64_decode( $this->merchantId );
		$this->account            = base64_decode( $this->account );
		$this->amount             = base64_decode( $this->amount );
		$this->authCode           = base64_decode( $this->authCode );
		$this->batchId            = base64_decode( $this->batchId );
		$this->cavv               = base64_decode( $this->cavv );
		$this->cvnResult          = base64_decode( $this->cvnResult );
		$this->eci                = base64_decode( $this->eci );
		$this->commentOne         = base64_decode( $this->commentOne );
		$this->commentTwo         = base64_decode( $this->commentTwo );
		$this->message            = base64_decode( $this->message );
		$this->pasRef             = base64_decode( $this->pasRef );
		$this->hash               = base64_decode( $this->hash );
		$this->result             = base64_decode( $this->result );
		$this->xid                = base64_decode( $this->xid );
		$this->orderId            = base64_decode( $this->orderId );
		$this->timeStamp          = base64_decode( $this->timeStamp );
		$this->AVSAddressResult   = base64_decode( $this->AVSAddressResult );
		$this->AVSPostCodeResult = base64_decode( $this->AVSPostCodeResult );

		foreach ( $this->tss as $key => $value ) {
			$this->tss[ $key ] = base64_decode( $value );
		}
		foreach ( $this->supplementaryData as $key => $value ) {
			$this->supplementaryData[ $key ] = base64_decode( $value );
		}

		return $this;
	}

}