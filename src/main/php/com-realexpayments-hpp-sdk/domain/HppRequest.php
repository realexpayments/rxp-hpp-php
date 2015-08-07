<?php


namespace com\realexpayments\hpp\sdk\domain;

use com\realexpayments\hpp\sdk\utils\GenerationUtils;
use Symfony\Component\Validator\Constraints as Assert;
use com\realexpayments\hpp\sdk\validators\ValidationMessages;

/**
 * <p>
 * Class representing a request to be sent to HPP.
 * </p>
 * <p>
 * Helper methods are provided (prefixed with 'add') for object creation.
 * </p>
 * <p>
 * Example usage:
 * <code><pre>
 * $request = (new HppRequest())
 *    ->addAmount(100)
 *    ->addCurrency("EUR")
 *    ->addMerchantId("merchantId");
 * </pre></code>
 * </p>
 *
 * @author vicpada
 */
class HppRequest {

	/**
	 * @var String The merchant ID supplied by Realex Payments – note this is not the merchant number
	 * supplied by your bank.
	 *
	 * @Assert\Length(min = 1, max = 50, minMessage = ValidationMessages::hppRequest_merchantId_size, maxMessage = ValidationMessages::hppRequest_merchantId_size)
	 * @Assert\NotBlank(message= ValidationMessages::hppRequest_merchantId_size)
	 * @Assert\Regex(pattern="/^[a-zA-Z0-9\.]*$/", message=ValidationMessages::hppRequest_merchantId_pattern )
	 */
	private $merchantId;

	/**
	 * @var String The sub-account to use for this transaction. If not present, the default sub-account will be used.
	 *
	 * @Assert\Length(min = 0, max = 30, maxMessage = ValidationMessages::hppRequest_account_size)
	 * @Assert\Regex(pattern="/^[a-zA-Z0-9\s]*$/", message=ValidationMessages::hppRequest_account_pattern )
	 */
	private $account;

	/**
	 * @var String A unique alphanumeric id that’s used to identify the transaction. No spaces are allowed.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = ValidationMessages::hppRequest_orderId_size)
	 * @Assert\Regex(pattern="/^[a-zA-Z0-9_\-]*$/", message=ValidationMessages::hppRequest_orderId_pattern )
	 */
	private $orderId;

	/**
	 * @var String Total amount to authorise in the lowest unit of the currency – i.e. 100 euro would be entered as 10000.
	 * If there is no decimal in the currency (e.g. JPY Yen) then contact Realex Payments. No decimal points are allowed.
	 * Amount should be set to 0 for OTB transactions (i.e. where validate card only is set to 1).
	 *
	 * @Assert\Length(min = 1, max = 11, minMessage = ValidationMessages::hppRequest_amount_size, maxMessage = ValidationMessages::hppRequest_amount_size)
	 * @Assert\NotBlank(message= ValidationMessages::hppRequest_amount_size)
	 * @Assert\Regex(pattern="/^[0-9]*$/", message=ValidationMessages::hppRequest_amount_pattern )
	 */
	private $amount;

	/**
	 * @var String A three-letter currency code (Eg. EUR, GBP). A list of currency codes can be provided
	 * by your account manager.
	 *
	 * @Assert\Length(min = 3, max = 3, exactMessage = ValidationMessages::hppRequest_currency_size)
	 * @Assert\NotBlank(message= ValidationMessages::hppRequest_currency_size)
	 * @Assert\Regex(pattern="/^[a-zA-Z]*$/", message=ValidationMessages::hppRequest_currency_pattern )
	 */
	private $currency;

	/**
	 * @var String Date and time of the transaction. Entered in the following format: YYYYMMDDHHMMSS.
	 * Must be within 24 hours of the current time.
	 *
	 * @Assert\Length(min = 14, max = 14, exactMessage = ValidationMessages::hppRequest_timestamp_size)
	 * @Assert\NotBlank(message= ValidationMessages::hppRequest_timestamp_size)
	 * @Assert\Regex(pattern="/^[0-9]*$/", message=ValidationMessages::hppRequest_timestamp_pattern )
	 */
	private $timeStamp;

	/**
	 * @var String A digital signature generated using the SHA-1 algorithm.
	 *
	 * @Assert\Length(min = 40, max =40, exactMessage = ValidationMessages::hppRequest_hash_size)
	 * @Assert\NotBlank(message= ValidationMessages::hppRequest_hash_size)
	 * @Assert\Regex(pattern="/^[a-f0-9]*$/", message=ValidationMessages::hppRequest_hash_pattern )
	 */
	private $hash;

	/**
	 * @var String Used to signify whether or not you wish the transaction to be captured in the next batch.
	 * If set to "1" and assuming the transaction is authorised then it will automatically be settled in the next batch.
	 * If set to "0" then the merchant must use the RealControl application to manually settle the transaction.
	 * This option can be used if a merchant wishes to delay the payment until after the goods have been shipped.
	 * Transactions can be settled for up to 115% of the original amount and must be settled within a certain period
	 * of time agreed with your issuing bank.
	 *
	 * @Assert\Regex(pattern="/(?i)^on$|^off$|^$|^multi$|^1$|^0$/", message=ValidationMessages::hppRequest_autoSettleFlag_pattern )
	 *
	 */
	private $autoSettleFlag;

	/**
	 * @var String A freeform comment to describe the transaction.
	 * @Assert\Length(min = 0, max = 255, maxMessage = ValidationMessages::hppRequest_comment1_size, charset="ISO-8859-1")*
	 * @Assert\Regex(pattern="/^[\s  -; = ?-~ ¡-ÿ€‚ƒ„…†‡ˆ‰Š‹ŒŽ‘’“”•–—˜™š›œžŸ]*$/", message=ValidationMessages::hppRequest_comment1_pattern )
	 */
	private $commentOne;

	/**
	 * @var String A freeform comment to describe the transaction.
	 *
	 * @Assert\Length(min = 0, max = 255, maxMessage = ValidationMessages::hppRequest_comment2_size, charset="ISO-8859-1")
	 * @Assert\Regex(pattern="/^[\s  -; = ?-~ ¡-ÿ€‚ƒ„…†‡ˆ‰Š‹ŒŽ‘’“”•–—˜™š›œžŸ]*$/", message=ValidationMessages::hppRequest_comment2_pattern )
	 */
	private $commentTwo;

	/**
	 * @var String Used to signify whether or not you want a Transaction Suitability Score for this transaction.
	 * Can be "0" for no and "1" for yes.
	 *
	 * @Assert\Length(min = 0, max = 1, maxMessage = ValidationMessages::hppRequest_returnTss_size)
	 * @Assert\Regex(pattern="/^[01]*$/", message=ValidationMessages::hppRequest_returnTss_pattern )
	 */
	private $returnTss;

	/**
	 * @var String The postcode or ZIP of the shipping address.
	 *
	 * @Assert\Length(min = 0, max = 30, maxMessage = ValidationMessages::hppRequest_shippingCode_size)
	 * @Assert\Regex(pattern="/^[A-Za-z0-9\,\.\-\/\| ]*$/", message=ValidationMessages::hppRequest_shippingCode_pattern )
	 */
	private $shippingCode;

	/**
	 * @var String The country of the shipping address.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = ValidationMessages::hppRequest_shippingCountry_size)
	 * @Assert\Regex(pattern="/^[A-Za-z0-9\,\.\- ]*$/", message=ValidationMessages::hppRequest_shippingCountry_pattern )
	 */
	private $shippingCountry;

	/**
	 * @var String The postcode or ZIP of the billing address.
	 *
	 * @Assert\Length(min = 0, max = 60, maxMessage = ValidationMessages::hppRequest_billingCode_size)
	 * @Assert\Regex(pattern="/^[A-Za-z0-9\,\.\-\/\| ]*$/", message=ValidationMessages::hppRequest_billingCode_pattern )
	 */
	private $billingCode;

	/**
	 * @var String The country of the billing address.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = ValidationMessages::hppRequest_billingCountry_size)
	 * @Assert\Regex(pattern="/^[A-Za-z0-9\,\.\- ]*$/", message=ValidationMessages::hppRequest_billingCountry_pattern )
	 */
	private $billingCountry;

	/**
	 * @var String The customer number of the customer. You can send in any additional information about
	 * the transaction in this field, which will be visible under the transaction in the RealControl application.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = ValidationMessages::hppRequest_customerNumber_size)
	 * @Assert\Regex(pattern="/^[a-zA-Z0-9\.\_\-\,\+\@ \s]*$/", message=ValidationMessages::hppRequest_customerNumber_pattern )
	 */
	private $customerNumber;

	/**
	 * @var String A variable reference also associated with this customer. You can send in any additional
	 * information about the transaction in this field, which will be visible under the transaction in
	 * the RealControl application.
	 */
	private $variableReference;

	/**
	 * @var String A product id associated with this product. You can send in any additional information about
	 * the transaction in this field, which will be visible under the transaction in the RealControl application.
	 */
	private $productId;

	/**
	 * @var String Used to set what language HPP is displayed in. Currently HPP is available in English, Spanish and
	 * German, with other languages to follow. If the field is not sent in, the default language is the language
	 * that is set in your account configuration. This can be set by your account manager.
	 */
	private $language;

	/**
	 * @var String Used to set what text is displayed on the payment button for card transactions.
	 * If this field is not sent in, "Pay Now" is displayed on the button by default.
	 */
	private $cardPaymentButtonText;

	//TODO: Next iteration
	//private $cardStorageEnable;
	//private $offerSaveCard;
	//private $payerReference;
	//private $paymentReference; 
	//private $payerExists;

	/**
	 * @var array Supplementary data to be sent to Realex Payments. This will be returned in the HPP response.
	 */
	private $supplementaryData;

	/**
	 * @var String Used to identify an OTB transaction.
	 */
	private $validateCardOnly;

	/**
	 * @var String Transaction level configuration to enable/disable a DCC request.
	 * (Only if the merchant is configured).
	 */
	private $dccEnable;

	/**
	 * Getter for merchantId
	 *
	 * @return String
	 */
	public function getMerchantId() {
		return $this->merchantId;
	}

	/**
	 * Setter for merchantId
	 *
	 * @param String $merchantId
	 */
	public function setMerchantId( $merchantId ) {
		$this->merchantId = $merchantId;
	}

	/**
	 * Getter for account
	 *
	 * @return String
	 */
	public function getAccount() {
		return $this->account;
	}

	/**
	 * Setter for account
	 *
	 * @param String $account
	 */
	public function setAccount( $account ) {
		$this->account = $account;
	}

	/**
	 * Getter for orderId
	 *
	 * @return String
	 */
	public function getOrderId() {
		return $this->orderId;
	}

	/**
	 * Setter for orderId
	 *
	 * @param String $orderId
	 */
	public function setOrderId( $orderId ) {
		$this->orderId = $orderId;
	}

	/**
	 * Getter for amount
	 *
	 * @return String
	 */
	public function getAmount() {
		return $this->amount;
	}

	/**
	 * Setter for amount
	 *
	 * @param String $amount
	 */
	public function setAmount( $amount ) {
		$this->amount = $amount;
	}

	/**
	 * Getter for currency
	 *
	 * @return String
	 */
	public function getCurrency() {
		return $this->currency;
	}

	/**
	 * Setter for currency
	 *
	 * @param String $currency
	 */
	public function setCurrency( $currency ) {
		$this->currency = $currency;
	}

	/**
	 * Getter for timeStamp
	 *
	 * @return String
	 */
	public function getTimeStamp() {
		return $this->timeStamp;
	}

	/**
	 * Setter for timeStamp
	 *
	 * @param String $timeStamp
	 */
	public function setTimeStamp( $timeStamp ) {
		$this->timeStamp = $timeStamp;
	}

	/**
	 * Getter for hash
	 *
	 * @return String
	 */
	public function getHash() {
		return $this->hash;
	}

	/**
	 * Setter for hash
	 *
	 * @param String $hash
	 */
	public function setHash( $hash ) {
		$this->hash = $hash;
	}

	/**
	 * Getter for autoSettleFlag
	 *
	 * @return String
	 */
	public function getAutoSettleFlag() {
		return $this->autoSettleFlag;
	}

	/**
	 * Setter for autoSettleFlag
	 *
	 * @param String $autoSettleFlag
	 */
	public function setAutoSettleFlag( $autoSettleFlag ) {
		$this->autoSettleFlag = $autoSettleFlag;
	}

	/**
	 * Getter for commentOne
	 *
	 * @return String
	 */
	public function getCommentOne() {
		return $this->commentOne;
	}

	/**
	 * Setter for commentOne
	 *
	 * @param String $commentOne
	 */
	public function setCommentOne( $commentOne ) {
		$this->commentOne = $commentOne;
	}

	/**
	 * Getter for commentTwo
	 *
	 * @return String
	 */
	public function getCommentTwo() {
		return $this->commentTwo;
	}

	/**
	 * Setter for commentTwo
	 *
	 * @param String $commentTwo
	 */
	public function setCommentTwo( $commentTwo ) {
		$this->commentTwo = $commentTwo;
	}

	/**
	 * Getter for returnTss
	 *
	 * @return String
	 */
	public function getReturnTss() {
		return $this->returnTss;
	}

	/**
	 * Setter for returnTss
	 *
	 * @param String $returnTss
	 */
	public function setReturnTss( $returnTss ) {
		$this->returnTss = $returnTss;
	}

	/**
	 * Getter for shippingCode
	 *
	 * @return String
	 */
	public function getShippingCode() {
		return $this->shippingCode;
	}

	/**
	 * Setter for shippingCode
	 *
	 * @param String $shippingCode
	 */
	public function setShippingCode( $shippingCode ) {
		$this->shippingCode = $shippingCode;
	}

	/**
	 * Getter for shippingCountry
	 *
	 * @return String
	 */
	public function getShippingCountry() {
		return $this->shippingCountry;
	}

	/**
	 * Setter for shippingCountry
	 *
	 * @param String $shippingCountry
	 */
	public function setShippingCountry( $shippingCountry ) {
		$this->shippingCountry = $shippingCountry;
	}

	/**
	 * Getter for billingCode
	 *
	 * @return String
	 */
	public function getBillingCode() {
		return $this->billingCode;
	}

	/**
	 * Setter for billingCode
	 *
	 * @param String $billingCode
	 */
	public function setBillingCode( $billingCode ) {
		$this->billingCode = $billingCode;
	}

	/**
	 * Getter for billingCountry
	 *
	 * @return String
	 */
	public function getBillingCountry() {
		return $this->billingCountry;
	}

	/**
	 * Setter for billingCountry
	 *
	 * @param String $billingCountry
	 */
	public function setBillingCountry( $billingCountry ) {
		$this->billingCountry = $billingCountry;
	}

	/**
	 * Getter for customerNumber
	 *
	 * @return String
	 */
	public function getCustomerNumber() {
		return $this->customerNumber;
	}

	/**
	 * Setter for customerNumber
	 *
	 * @param String $customerNumber
	 */
	public function setCustomerNumber( $customerNumber ) {
		$this->customerNumber = $customerNumber;
	}

	/**
	 * Getter for variableReference
	 *
	 * @return String
	 */
	public function getVariableReference() {
		return $this->variableReference;
	}

	/**
	 * Setter for variableReference
	 *
	 * @param String $variableReference
	 */
	public function setVariableReference( $variableReference ) {
		$this->variableReference = $variableReference;
	}

	/**
	 * Getter for productId
	 *
	 * @return String
	 */
	public function getProductId() {
		return $this->productId;
	}

	/**
	 * Setter for productId
	 *
	 * @param String $productId
	 */
	public function setProductId( $productId ) {
		$this->productId = $productId;
	}

	/**
	 * Getter for language
	 *
	 * @return String
	 */
	public function getLanguage() {
		return $this->language;
	}

	/**
	 * Setter for language
	 *
	 * @param String $language
	 */
	public function setLanguage( $language ) {
		$this->language = $language;
	}

	/**
	 * Getter for cardPaymentButtonText
	 *
	 * @return String
	 */
	public function getCardPaymentButtonText() {
		return $this->cardPaymentButtonText;
	}

	/**
	 * Setter for cardPaymentButtonText
	 *
	 * @param String $cardPaymentButtonText
	 */
	public function setCardPaymentButtonText( $cardPaymentButtonText ) {
		$this->cardPaymentButtonText = $cardPaymentButtonText;
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
	 * @param array $supplementaryData
	 */
	public function setSupplementaryData( array $supplementaryData ) {
		$this->supplementaryData = $supplementaryData;
	}

	/**
	 * Getter for validateCardOnly
	 *
	 * @return String
	 */
	public function getValidateCardOnly() {
		return $this->validateCardOnly;
	}

	/**
	 * Setter for validateCardOnly
	 *
	 * @param String $validateCardOnly
	 */
	public function setValidateCardOnly( $validateCardOnly ) {
		$this->validateCardOnly = $validateCardOnly;
	}

	/**
	 * Getter for dccEnable
	 *
	 * @return String
	 */
	public function getDccEnable() {
		return $this->dccEnable;
	}

	/**
	 * Setter for dccEnable
	 *
	 * @param String $dccEnable
	 */
	public function setDccEnable( $dccEnable ) {
		$this->dccEnable = $dccEnable;
	}


	/**
	 * Helper method for adding a merchantId
	 *
	 * @param String $merchantId
	 *
	 * @return HppRequest
	 */
	public function addMerchantId( $merchantId ) {
		$this->merchantId = $merchantId;

		return $this;
	}

	/**
	 * Helper method for adding a account
	 *
	 * @param String $account
	 *
	 * @return HppRequest
	 */
	public function addAccount( $account ) {
		$this->account = $account;

		return $this;
	}

	/**
	 * Helper method for adding a orderId
	 *
	 * @param String $orderId
	 *
	 * @return HppRequest
	 */
	public function addOrderId( $orderId ) {
		$this->orderId = $orderId;

		return $this;
	}

	/**
	 * Helper method for adding a amount
	 *
	 * @param String $amount
	 *
	 * @return HppRequest
	 */
	public function addAmount( $amount ) {
		$this->amount = $amount;

		return $this;
	}

	/**
	 * Helper method for adding a currency
	 *
	 * @param String $currency
	 *
	 * @return HppRequest
	 */
	public function addCurrency( $currency ) {
		$this->currency = $currency;

		return $this;
	}

	/**
	 * Helper method for adding a timeStamp
	 *
	 * @param String $timeStamp
	 *
	 * @return HppRequest
	 */
	public function addTimeStamp( $timeStamp ) {
		$this->timeStamp = $timeStamp;

		return $this;
	}

	/**
	 * Helper method for adding a hash
	 *
	 * @param String $hash
	 *
	 * @return HppRequest
	 */
	public function addHash( $hash ) {
		$this->hash = $hash;

		return $this;
	}

	/**
	 * Helper method for adding a autoSettleFlag
	 *
	 * @param String $autoSettleFlag
	 *
	 * @return HppRequest
	 */
	public function addAutoSettleFlag( $autoSettleFlag ) {
		$this->autoSettleFlag = $autoSettleFlag;

		return $this;
	}

	/**
	 * Helper method for adding a commentOne
	 *
	 * @param String $commentOne
	 *
	 * @return HppRequest
	 */
	public function addCommentOne( $commentOne ) {
		$this->commentOne = $commentOne;

		return $this;
	}

	/**
	 * Helper method for adding a commentTwo
	 *
	 * @param String $commentTwo
	 *
	 * @return HppRequest
	 */
	public function addCommentTwo( $commentTwo ) {
		$this->commentTwo = $commentTwo;

		return $this;
	}

	/**
	 * Helper method for adding a returnTss
	 *
	 * @param String $returnTss
	 *
	 * @return HppRequest
	 */
	public function addReturnTss( $returnTss ) {
		$this->returnTss = $returnTss;

		return $this;
	}

	/**
	 * Helper method for adding a shippingCode
	 *
	 * @param String $shippingCode
	 *
	 * @return HppRequest
	 */
	public function addShippingCode( $shippingCode ) {
		$this->shippingCode = $shippingCode;

		return $this;
	}

	/**
	 * Helper method for adding a shippingCountry
	 *
	 * @param String $shippingCountry
	 *
	 * @return HppRequest
	 */
	public function addShippingCountry( $shippingCountry ) {
		$this->shippingCountry = $shippingCountry;

		return $this;
	}

	/**
	 * Helper method for adding a billingCode
	 *
	 * @param String $billingCode
	 *
	 * @return HppRequest
	 */
	public function addBillingCode( $billingCode ) {
		$this->billingCode = $billingCode;

		return $this;
	}

	/**
	 * Helper method for adding a billingCountry
	 *
	 * @param String $billingCountry
	 *
	 * @return HppRequest
	 */
	public function addBillingCountry( $billingCountry ) {
		$this->billingCountry = $billingCountry;

		return $this;
	}

	/**
	 * Helper method for adding a customerNumber
	 *
	 * @param String $customerNumber
	 *
	 * @return HppRequest
	 */
	public function addCustomerNumber( $customerNumber ) {
		$this->customerNumber = $customerNumber;

		return $this;
	}

	/**
	 * Helper method for adding a variableReference
	 *
	 * @param String $variableReference
	 *
	 * @return HppRequest
	 */
	public function addVariableReference( $variableReference ) {
		$this->variableReference = $variableReference;

		return $this;
	}

	/**
	 * Helper method for adding a productId
	 *
	 * @param String $productId
	 *
	 * @return HppRequest
	 */
	public function addProductId( $productId ) {
		$this->productId = $productId;

		return $this;
	}

	/**
	 * Helper method for adding a language
	 *
	 * @param String $language
	 *
	 * @return HppRequest
	 */
	public function addLanguage( $language ) {
		$this->language = $language;

		return $this;
	}

	/**
	 * Helper method for adding a cardPaymentButtonText
	 *
	 * @param String $cardPaymentButtonText
	 *
	 * @return HppRequest
	 */
	public function addCardPaymentButtonText( $cardPaymentButtonText ) {
		$this->cardPaymentButtonText = $cardPaymentButtonText;

		return $this;
	}

	/**
	 * Helper method for adding a supplementaryData
	 *
	 * @param array $supplementaryData
	 *
	 * @return HppRequest
	 */
	public function addSupplementaryData( array $supplementaryData ) {
		$this->supplementaryData = $supplementaryData;

		return $this;
	}

	/**
	 * Helper method for adding a validateCardOnly
	 *
	 * @param String $validateCardOnly
	 *
	 * @return HppRequest
	 */
	public function addValidateCardOnly( $validateCardOnly ) {
		$this->validateCardOnly = $validateCardOnly;

		return $this;
	}

	/**
	 * Helper method for adding a dccEnable
	 *
	 * @param String $dccEnable
	 *
	 * @return HppRequest
	 */
	public function addDccEnable( $dccEnable ) {
		$this->dccEnable = $dccEnable;

		return $this;
	}


	/**
	 * Generates default values for fields such as hash, timestamp and order ID.
	 *
	 * @param String $secret
	 *
	 * @return HppRequest
	 */
	public function generateDefaults( $secret ) {

		//generate timestamp if not set
		if ( is_null( $this->timeStamp ) ) {
			$this->timeStamp = GenerationUtils::generateTimestamp();
		}

		//generate order ID if not set
		if ( is_null( $this->orderId ) ) {
			$this->orderId = GenerationUtils::generateOrderId();
		}

		//generate hash
		$this->hash( $secret );

		return $this;
	}

	/**
	 * Creates the security hash from a number of fields and the shared secret.
	 *
	 * @param string $secret
	 *
	 * @return HppRequest
	 */
	public function hash( $secret ) {

		//check for any null values and set them to empty string for hashing
		$timeStamp        = null == $this->timeStamp ? "" : $this->timeStamp;
		$merchantId       = null == $this->merchantId ? "" : $this->merchantId;
		$orderId          = null == $this->orderId ? "" : $this->orderId;
		$amount           = null == $this->amount ? "" : $this->amount;
		$currency         = null == $this->currency ? "" : $this->currency;
		$payerReference   = "";   //= null == $this->payerReference ? "" : $this->payerReference; //TODO: Next iteration
		$paymentReference = "";// = null == $this->paymentReference ? "" : $this->paymentReference;

		//create String to hash

		//TODO: Next iteration
		/*if ($this->cardStorageEnable) {
			$toHash = $timeStamp
			          . "."
			          . $merchantId
			          . "."
			          . $orderId
			          . "."
			          . $amount
			          . "."
			          . $currency
			          . "."
			          . $payerReference
			          . "."
			          . $paymentReference;
		} else */

		$toHash = $timeStamp
		          . "."
		          . $merchantId
		          . "."
		          . $orderId
		          . "."
		          . $amount
		          . "."
		          . $currency;


		$this->hash = GenerationUtils::generateHash( $toHash, $secret );

		return $this;

	}

	public function encode( $charSet ) {
		//TODO
	}

	public function decode( $charSet ) {
		//TODO
	}


}

