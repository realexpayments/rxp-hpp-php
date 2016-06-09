<?php


namespace com\realexpayments\hpp\sdk\domain;

use com\realexpayments\hpp\sdk\utils\GenerationUtils;
use com\realexpayments\hpp\sdk\validators as AssertHPP;
use com\realexpayments\hpp\sdk\validators\ValidationMessages;
use Symfony\Component\Validator\Constraints as Assert;

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
 * @AssertHPP\OtbAmount
 * @AssertHPP\SupplementaryDataLength
 * @AssertHPP\SupplementaryDataPattern
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
	 * @Assert\Length(min = 0, max = 255, maxMessage = ValidationMessages::hppRequest_comment1_size, charset="ISO-8859-1")
	 * @Assert\Regex(pattern="/^[\s \x{0020}-\x{003B} \x{003D} \x{003F}-\x{007E} \x{00A1}-\x{00FF}\x{20AC}\x{201A}\x{0192}\x{201E}\x{2026}\x{2020}\x{2021}\x{02C6}\x{2030}\x{0160}\x{2039}\x{0152}\x{017D}\x{2018}\x{2019}\x{201C}\x{201D}\x{2022}\x{2013}\x{2014}\x{02DC}\x{2122}\x{0161}\x{203A}\x{0153}\x{017E}\x{0178}]*$/iu", message=ValidationMessages::hppRequest_comment1_pattern )
	 */
	private $commentOne;

	/**
	 * @var String A freeform comment to describe the transaction.
	 *
	 * @Assert\Length(min = 0, max = 255, maxMessage = ValidationMessages::hppRequest_comment2_size, charset="ISO-8859-1")
	 * @Assert\Regex(pattern="/^[\s \x{0020}-\x{003B} \x{003D} \x{003F}-\x{007E} \x{00A1}-\x{00FF}\x{20AC}\x{201A}\x{0192}\x{201E}\x{2026}\x{2020}\x{2021}\x{02C6}\x{2030}\x{0160}\x{2039}\x{0152}\x{017D}\x{2018}\x{2019}\x{201C}\x{201D}\x{2022}\x{2013}\x{2014}\x{02DC}\x{2122}\x{0161}\x{203A}\x{0153}\x{017E}\x{0178}]*$/iu", message=ValidationMessages::hppRequest_comment2_pattern )
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
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = ValidationMessages::hppRequest_variableReference_size)
	 * @Assert\Regex(pattern="/^[a-zA-Z0-9\.\_\-\,\+\@ \s]*$/", message=ValidationMessages::hppRequest_variableReference_pattern )
	 */
	private $variableReference;

	/**
	 * @var String A product id associated with this product. You can send in any additional information about
	 * the transaction in this field, which will be visible under the transaction in the RealControl application.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = ValidationMessages::hppRequest_productId_size)
	 * @Assert\Regex(pattern="/^[a-zA-Z0-9\.\_\-\,\+\@ \s]*$/", message=ValidationMessages::hppRequest_productId_pattern )
	 */
	private $productId;

	/**
	 * @var String Used to set what language HPP is displayed in. Currently HPP is available in English, Spanish and
	 * German, with other languages to follow. If the field is not sent in, the default language is the language
	 * that is set in your account configuration. This can be set by your account manager.
	 *
	 * @Assert\Regex(pattern="/^[a-zA-Z]{2}$|^[a-zA-Z]{0}$/", message=ValidationMessages::hppRequest_language_pattern )
	 */
	private $language;

	/**
	 * @var String Used to set what text is displayed on the payment button for card transactions.
	 * If this field is not sent in, "Pay Now" is displayed on the button by default.
	 *
	 * @Assert\Length(min = 0, max = 25, maxMessage = ValidationMessages::hppRequest_cardPaymentButtonText_size)
	 * @Assert\Regex(pattern = "/^[\x{00C0}\x{00C1}\x{00C2}\x{00C3}\x{00C4}\x{00C5}\x{00C6}\x{00C7}\x{00C8}\x{00C9}\x{00CA}\x{00CB}\x{00CC}\x{00CD}\x{00CE}\x{00CF}\x{00D0}\x{00D1}\x{00D2}\x{00D3}\x{00D4}\x{00D5}\x{00D6}\x{00D7}\x{00D8}\x{00D9}\x{00DA}\x{00DB}\x{00DC}\x{00DD}\x{00DE}\x{00DF}\x{00E0}\x{00E1}\x{00E2}\x{00E3}\x{00E4}\x{00E5}\x{00E6}\x{00E7}\x{00E8}\x{00E9}\x{00EA}\x{00EB}\x{00EC}\x{00ED}\x{00EE}\x{00EF}\x{00F0}\x{00F1}\x{00F2}\x{00F3}\x{00F4}\x{00F5}\x{00F6}\x{00F7}\x{00F8}\x{00A4}\x{00F9}\x{00FA}\x{00FB}\x{00FC}\x{00FD}\x{00FE}\x{00FF}\x{0152}\x{017D}\x{0161}\x{0153}\x{017E}\x{0178}\x{00A5}a-zA-Z0-9\'\,\+\x{0022}\.\_\-\&\/\@\!\?\%\()\*\:\x{00A3}\$\&\x{20AC}\#\[\]\|\=\\\x{201C}\x{201D}\x{201C} ]*$/iu" , message=ValidationMessages::hppRequest_cardPaymentButtonText_pattern )
	 */
	private $cardPaymentButtonText;


	/**
	 * @var string Enable card storage.
	 *
	 * @Assert\Length(min = 0, max = 1, maxMessage = ValidationMessages::hppRequest_cardStorageEnable_size)
	 * @Assert\Regex(pattern = "/^[10]*$/" , message=ValidationMessages::hppRequest_cardStorageEnable_pattern )
	 */
	private $cardStorageEnable;

	/**
	 * @var string Offer to save the card.
	 *
	 * @Assert\Length(min = 0, max = 1, maxMessage = ValidationMessages::hppRequest_offerSaveCard_size)
	 * @Assert\Regex(pattern = "/^[10]*$/" , message=ValidationMessages::hppRequest_offerSaveCard_pattern )
	 */
	private $offerSaveCard;

	/**
	 * @var string The payer reference.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = ValidationMessages::hppRequest_payerReference_size)
	 * @Assert\Regex(pattern = "/^[A-Za-z0-9\_\-\\ ]*$/" , message=ValidationMessages::hppRequest_payerReference_pattern )
	 */
	private $payerReference;

	/**
	 * @var string The payment reference.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = ValidationMessages::hppRequest_paymentReference_size)
	 * @Assert\Regex(pattern = "/^[A-Za-z0-9\_\-]*$/" , message=ValidationMessages::hppRequest_paymentReference_pattern )
	 */
	private $paymentReference;

	/**
	 * @var string Flag to indicate if the payer exists.
	 *
	 * @Assert\Length(min = 0, max = 1, maxMessage = ValidationMessages::hppRequest_payerExists_size)
	 * @Assert\Regex(pattern = "/^[102]*$/" , message=ValidationMessages::hppRequest_payerExists_pattern )
	 */
	private $payerExists;

	/**
	 * @var string[] Supplementary data to be sent to Realex Payments. This will be returned in the HPP response.
	 * Fields will be 255 char max
	 */
	private $supplementaryData = array();

	/**
	 * @var String Used to identify an OTB transaction.
	 *
	 * @Assert\Length(min = 0, max = 1, maxMessage = ValidationMessages::hppRequest_validateCardOnly_size)
	 * @Assert\Regex(pattern="/^[01]*$/", message=ValidationMessages::hppRequest_validateCardOnly_pattern )
	 */
	private $validateCardOnly;

	/**
	 * @var String Transaction level configuration to enable/disable a DCC request.
	 * (Only if the merchant is configured).
	 *
	 * @Assert\Length(min = 0, max = 1, maxMessage = ValidationMessages::hppRequest_dccEnable_size)
	 * @Assert\Regex(pattern="/^[01]*$/", message=ValidationMessages::hppRequest_dccEnable_pattern )
	 */
	private $dccEnable;

	/**
	 * @var As per the commit reference, can only have the value 1 or 2. Passing 2 enables the new skin for the HPP.
	 * It also allows HPP_SELECT_STORED_CARD to be sent.
	 *
	 * @Assert\Length(min = 0, max = 1, maxMessage = ValidationMessages::hppRequest_hppVersion_size)
	 * @Assert\Regex(pattern="/^[1-2]*$/", message=ValidationMessages::hppRequest_hppVersion_pattern )
	 */
	private $hppVersion;

	/**
	 * @var As per the commit reference, must contain the Payer reference of the customer whose cards the merchant wishes
	 * to display on the HPP. If sent correctly, all of the customer’s saved cards will be displayed and they can choose
	 * which one they wish to complete the payment with.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = ValidationMessages::hppRequest_hppSelectStoredCard_size)
	 * @Assert\Regex(pattern="/^[A-Za-z0-9\_\-\\ ]*$/", message=ValidationMessages::hppRequest_hppSelectStoredCard_pattern )
	 */
	private $hppSelectedStoredCard;

	/**
	 * @var string This field should contain the domain of the page hosting the iFrame calling HPP. If sent correctly,
	 * every time the height or width of the card form changes (e.g. an error message appears),
	 * the HPP will send this back as a JSON string to the parent iFrame.
	 * This is to facilitate developers who wish to resize their iFrame accordingly on increases or decreases of the HPP form’s size.
	 * @Assert\Length(min = 0, max = 255, maxMessage = ValidationMessages::hppRequest_postDimensions_size, charset="ISO-8859-1")
	 * @Assert\Regex(pattern="/^[\s \x{0020}-\x{003B} \x{003D} \x{003F}-\x{007E} \x{00A1}-\x{00FF}\x{20AC}\x{201A}\x{0192}\x{201E}\x{2026}\x{2020}\x{2021}\x{02C6}\x{2030}\x{0160}\x{2039}\x{0152}\x{017D}\x{2018}\x{2019}\x{201C}\x{201D}\x{2022}\x{2013}\x{2014}\x{02DC}\x{2122}\x{0161}\x{203A}\x{0153}\x{017E}\x{0178}]*$/iu", message=ValidationMessages::hppRequest_postDimensions_pattern )

	 */
	private $postDimensions ;

	/**
	 * @var string This field should contain the domain of the page hosting the iFrame calling HPP. If sent correctly,
	 * every time the height or width of the card form changes (e.g. an error message appears),
	 * the HPP will send this back as a JSON string to the parent iFrame.
	 * This is to facilitate developers who wish to resize their iFrame accordingly on increases or decreases of the HPP form’s size.
	 *
	 * @Assert\Length(min = 0, max = 255, maxMessage = ValidationMessages::hppRequest_postResponse_size, charset="ISO-8859-1")
	 * @Assert\Regex(pattern="/^[\s \x{0020}-\x{003B} \x{003D} \x{003F}-\x{007E} \x{00A1}-\x{00FF}\x{20AC}\x{201A}\x{0192}\x{201E}\x{2026}\x{2020}\x{2021}\x{02C6}\x{2030}\x{0160}\x{2039}\x{0152}\x{017D}\x{2018}\x{2019}\x{201C}\x{201D}\x{2022}\x{2013}\x{2014}\x{02DC}\x{2122}\x{0161}\x{203A}\x{0153}\x{017E}\x{0178}]*$/iu", message=ValidationMessages::hppRequest_postResponse_pattern )
	 */

	private $postResponse;

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
	 * @return string[]
	 */
	public function getSupplementaryData() {
		return $this->supplementaryData;
	}

	/**
	 * Setter for supplementaryData
	 *
	 * <p>
	 * Example usage:
	 * <code><pre>
	 * $data = array();
	 * $data["key1"] = "value1";
	 * $data["key2"] = "value2";
	 *
	 * $request = (new HppRequest());
	 * $request->setSupplementaryData($data);
	 * </pre></code>
	 * </p>
	 *
	 * @param string[] $supplementaryData
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
	 * Getter for cardStorageEnable
	 *
	 * @return mixed
	 */
	public function getCardStorageEnable() {
		return $this->cardStorageEnable;
	}

	/**
	 * Setter for cardStorageEnable
	 *
	 * @param mixed $cardStorageEnable
	 */
	public function setCardStorageEnable( $cardStorageEnable ) {
		$this->cardStorageEnable = $cardStorageEnable;
	}

	/**
	 * Getter for offerSaveCard
	 *
	 * @return string
	 */
	public function getOfferSaveCard() {
		return $this->offerSaveCard;
	}

	/**
	 * Setter for offerSaveCard
	 *
	 * @param string $offerSaveCard
	 */
	public function setOfferSaveCard( $offerSaveCard ) {
		$this->offerSaveCard = $offerSaveCard;
	}

	/**
	 * Getter for payerReference
	 *
	 * @return string
	 */
	public function getPayerReference() {
		return $this->payerReference;
	}

	/**
	 * Setter for payerReference
	 *
	 * @param string $payerReference
	 */
	public function setPayerReference( $payerReference ) {
		$this->payerReference = $payerReference;
	}

	/**
	 * Getter for paymentReference
	 *
	 * @return string
	 */
	public function getPaymentReference() {
		return $this->paymentReference;
	}

	/**
	 * Setter for paymentReference
	 *
	 * @param string $paymentReference
	 */
	public function setPaymentReference( $paymentReference ) {
		$this->paymentReference = $paymentReference;
	}

	/**
	 * Getter for payerExists
	 *
	 * @return string
	 */
	public function getPayerExists() {
		return $this->payerExists;
	}

	/**
	 * Setter for payerExists
	 *
	 * @param string $payerExists
	 */
	public function setPayerExists( $payerExists ) {
		$this->payerExists = $payerExists;
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
	 * @param String|bool $autoSettleFlag
	 *
	 * @return HppRequest
	 */
	public function addAutoSettleFlag( $autoSettleFlag ) {
		if ( is_bool( $autoSettleFlag ) ) {
			$this->autoSettleFlag = $autoSettleFlag ? Flag::TRUE : Flag::FALSE;
		} else {
			$this->autoSettleFlag = $autoSettleFlag;
		}

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
	 * @param String|bool $returnTss
	 *
	 * @return HppRequest
	 */
	public function addReturnTss( $returnTss ) {
		if ( is_bool( $returnTss ) ) {
			$this->returnTss = $returnTss ? Flag::TRUE : Flag::FALSE;
		} else {
			$this->returnTss = $returnTss;
		}

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
	 * <p>
	 * Example usage:
	 * <code><pre>
	 * $data = array();
	 * $data["key1"] = "value1";
	 * $data["key2"] = "value2";
	 *
	 * $request = (new HppRequest())
	 *    ->addAmount(100)
	 *    ->addCurrency("EUR")
	 *    ->addMerchantId("merchantId");
	 *    ->addSupplementaryData($data);
	 * </pre></code>
	 * </p>
	 *
	 * @param string[] $supplementaryData
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
	 * @param String|bool $validateCardOnly
	 *
	 * @return HppRequest
	 */
	public function addValidateCardOnly( $validateCardOnly ) {
		if ( is_bool( $validateCardOnly ) ) {
			$this->validateCardOnly = $validateCardOnly ? Flag::TRUE : Flag::FALSE;
		} else {
			$this->validateCardOnly = $validateCardOnly;
		}

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
		if ( is_bool( $dccEnable ) ) {
			$this->dccEnable = $dccEnable ? Flag::TRUE : Flag::FALSE;
		} else {
			$this->dccEnable = $dccEnable;
		}

		return $this;
	}

	/**
	 * Helper method for adding a cardStorageEnable
	 *
	 * @param mixed|bool $cardStorageEnable
	 *
	 * @return HppRequest
	 */
	public function addCardStorageEnable( $cardStorageEnable ) {
		if ( is_bool( $cardStorageEnable ) ) {
			$this->cardStorageEnable = $cardStorageEnable ? Flag::TRUE : Flag::FALSE;
		} else {
			$this->cardStorageEnable = $cardStorageEnable;
		}

		return $this;
	}

	/**
	 * Helper method for adding a offerSaveCard
	 *
	 * @param string|bool $offerSaveCard
	 *
	 * @return HppRequest
	 */
	public function addOfferSaveCard( $offerSaveCard ) {
		if ( is_bool( $offerSaveCard ) ) {
			$this->offerSaveCard = $offerSaveCard ? Flag::TRUE : Flag::FALSE;
		} else {
			$this->offerSaveCard = $offerSaveCard;
		}

		return $this;
	}

	/**
	 * Helper method for adding a payerReference
	 *
	 * @param string $payerReference
	 *
	 * @return HppRequest
	 */
	public function addPayerReference( $payerReference ) {
		$this->payerReference = $payerReference;

		return $this;
	}

	/**
	 * Helper method for adding a paymentReference
	 *
	 * @param string $paymentReference
	 *
	 * @return HppRequest
	 */
	public function addPaymentReference( $paymentReference ) {
		$this->paymentReference = $paymentReference;

		return $this;
	}

	/**
	 * Helper method for adding a payerExists
	 *
	 * @param string|bool $payerExists
	 *
	 * @return HppRequest
	 */
	public function addPayerExists( $payerExists ) {
		if ( is_bool( $payerExists ) ) {
			$this->payerExists = $payerExists ? Flag::TRUE : Flag::FALSE;
		} else {
			$this->payerExists = $payerExists;
		}

		return $this;
	}

	/**
	 * Helper method for adding the Hpp Version
	 *
	 * @param string $hppVersion
	 *
	 * @return HppRequest
	 */
	public function addHppVersion( $hppVersion ){
		if ( is_bool( $hppVersion ) ) {
			$this->cardStorageEnable = $hppVersion ? Flag::TRUE : Flag::FALSE;
		} else {
			$this->hppVersion = $hppVersion;
		}


		return $this;
	}

	/**
	 * Helper method for setting the Hpp Version
	 *
	 * @param string $hppVersion
	 *
	 * @return void
	 */
	public function setHppVersion( $hppVersion ){
		$this->hppVersion = $hppVersion;

	}

	/**
	 * Helper method for adding the Hpp Version
	 *
	 * @return hppVersion
	 */
	public function getHppVersion(){
		return $this->hppVersion ;

	}

	/**
	 * Helper method for adding the Hpp Selected Stored Card
	 *
	 * @param string $hppSelectedStoredCard
	 *
	 * @return HppRequest
	 */
	public function addHppSelectedStoredCard( $hppSelectedStoredCard ){
		$this->hppSelectedStoredCard = $hppSelectedStoredCard;

		return $this;
	}

	/**
	 * Helper method for setting the Hpp Selected Stored Card
	 *
	 * @param string $hppSelectedStoredCard
	 *
	 * @return void
	 */
	public function setHppSelectedStoredCard( $hppSelectedStoredCard ){
		$this->hppSelectedStoredCard = $hppSelectedStoredCard;
	}

	/**
	 * Helper method for adding the Hpp Selected Stored Card
	 *
	 * @return hppSelectedStoredCard
	 */
	public function getHppSelectedStoredCard( ){
		return $this->hppSelectedStoredCard ;

	}

	/**
	 * Helper method for adding the Hpp Post Dimension
	 *
	 * @param string $postDimensions
	 *
	 * @return HppRequest
	 */
	public function addPostDimensions( $postDimensions ){
		$this->postDimensions = $postDimensions;

		return $this;
	}

	/**
	 * Helper method for setting the Hpp Post Dimension
	 *
	 * @param string $postDimensions
	 *
	 * @return void
	 */
	public function setPostDimensions( $postDimensions ){
		$this->postDimensions = $postDimensions;

	}

	/**
	 * Helper method for adding the Hpp Post Dimension
	 *
	 * @return postDimensions
	 */
	public function getPostDimensions( ){
		return $this->postDimensions ;

	}

	/**
	 * Helper method for adding the Hpp Post Dimension
	 *
	 * @param string $postResponse
	 *
	 * @return HppRequest
	 */
	public function addPostResponse(  $postResponse ){
		$this->postResponse = $postResponse;

		return $this;
	}

	/**
	 * Helper method for setting the Hpp Post Dimension
	 *
	 * @param string $postResponse
	 *
	 * @return void
	 */
	public function setPostResponse( $postResponse ){
		$this->postResponse = $postResponse;

	}

	/**
	 * Helper method for adding the Hpp Post Dimension
	 *
	 * @return postDimensions
	 */
	public function getPostResponse(){
		return $this->postResponse ;

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
		$payerReference   = null == $this->payerReference ? "" : $this->payerReference;
		$paymentReference = null == $this->paymentReference ? "" : $this->paymentReference;
		$hppSelectedStoredCard = null == $this->hppSelectedStoredCard ? "" : $this->hppSelectedStoredCard;

		//create String to hash

		$payRefORStoredCard =  empty($hppSelectedStoredCard) ?  $payerReference : $hppSelectedStoredCard;


		if ( $this->cardStorageEnable ) {
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
		} else	if ($payRefORStoredCard && empty($paymentReference) ) {
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
			. $payRefORStoredCard
			. ".";

		} else	if ( $payRefORStoredCard && !empty($paymentReference) ) {
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
			. $payRefORStoredCard
			. "."
			. $paymentReference;

		}else {
			$toHash = $timeStamp
				. "."
				. $merchantId
				. "."
				. $orderId
				. "."
				. $amount
				. "."
				. $currency;
		}

		$this->hash = GenerationUtils::generateHash( $toHash, $secret );

		return $this;

	}


	/**
	 * Base64 encodes all Hpp Request values.
	 *
	 * @param string $charSet
	 *
	 * @return HppRequest
	 */
	public function encode( $charSet ) {
		$this->account               = base64_encode( $this->account );
		$this->amount                = base64_encode( $this->amount );
		$this->autoSettleFlag        = base64_encode( $this->autoSettleFlag );
		$this->billingCode           = base64_encode( $this->billingCode );
		$this->billingCountry        = base64_encode( $this->billingCountry );
		$this->cardPaymentButtonText = base64_encode( $this->cardPaymentButtonText );
		$this->cardStorageEnable     = base64_encode( $this->cardStorageEnable );
		$this->commentOne            = base64_encode( $this->commentOne );
		$this->commentTwo            = base64_encode( $this->commentTwo );
		$this->currency              = base64_encode( $this->currency );
		$this->customerNumber        = base64_encode( $this->customerNumber );
		$this->hash                  = base64_encode( $this->hash );
		$this->language              = base64_encode( $this->language );
		$this->merchantId            = base64_encode( $this->merchantId );
		$this->offerSaveCard         = base64_encode( $this->offerSaveCard );
		$this->orderId               = base64_encode( $this->orderId );
		$this->payerExists           = base64_encode( $this->payerExists );
		$this->payerReference        = base64_encode( $this->payerReference );
		$this->paymentReference      = base64_encode( $this->paymentReference );
		$this->productId             = base64_encode( $this->productId );
		$this->returnTss             = base64_encode( $this->returnTss );
		$this->shippingCode          = base64_encode( $this->shippingCode );
		$this->shippingCountry       = base64_encode( $this->shippingCountry );
		$this->timeStamp             = base64_encode( $this->timeStamp );
		$this->variableReference     = base64_encode( $this->variableReference );
		$this->validateCardOnly 	 = base64_encode( $this->validateCardOnly );
		$this->dccEnable         	 = base64_encode( $this->dccEnable );
		$this->hppVersion     		 = base64_encode( $this->hppVersion );
		$this->hppSelectedStoredCard    = base64_encode( $this->hppSelectedStoredCard );
		$this->postResponse   		 = base64_encode( $this->postResponse );
		$this->postDimensions   	 = base64_encode( $this->postDimensions );

		if ( is_array( $this->supplementaryData ) ) {
			foreach ( $this->supplementaryData as $key => $value ) {
				$this->supplementaryData[ $key ] = base64_encode( $value );
			}
		}




		return $this;
	}

	/**
	 * Base64 decodes all Hpp Request values.
	 *
	 * @param string $charSet
	 *
	 * @return HppRequest
	 */
	public function decode( $charSet ) {
		$this->account               = base64_decode( $this->account );
		$this->amount                = base64_decode( $this->amount );
		$this->autoSettleFlag        = base64_decode( $this->autoSettleFlag );
		$this->billingCode           = base64_decode( $this->billingCode );
		$this->billingCountry        = base64_decode( $this->billingCountry );
		$this->cardPaymentButtonText = base64_decode( $this->cardPaymentButtonText );
		$this->cardStorageEnable     = base64_decode( $this->cardStorageEnable );
		$this->commentOne            = base64_decode( $this->commentOne );
		$this->commentTwo            = base64_decode( $this->commentTwo );
		$this->currency              = base64_decode( $this->currency );
		$this->customerNumber        = base64_decode( $this->customerNumber );
		$this->hash                  = base64_decode( $this->hash );
		$this->language              = base64_decode( $this->language );
		$this->merchantId            = base64_decode( $this->merchantId );
		$this->offerSaveCard         = base64_decode( $this->offerSaveCard );
		$this->orderId               = base64_decode( $this->orderId );
		$this->payerExists           = base64_decode( $this->payerExists );
		$this->payerReference        = base64_decode( $this->payerReference );
		$this->paymentReference      = base64_decode( $this->paymentReference );
		$this->productId             = base64_decode( $this->productId );
		$this->returnTss             = base64_decode( $this->returnTss );
		$this->shippingCode          = base64_decode( $this->shippingCode );
		$this->shippingCountry       = base64_decode( $this->shippingCountry );
		$this->timeStamp             = base64_decode( $this->timeStamp );
		$this->variableReference     = base64_decode( $this->variableReference );
		$this->validateCardOnly      = base64_decode( $this->validateCardOnly );
		$this->dccEnable       		 = base64_decode( $this->dccEnable );
		$this->hppVersion     		 = base64_decode( $this->hppVersion );
		$this->hppSelectedStoredCard   	= base64_decode( $this->hppSelectedStoredCard );
		$this->postResponse   		= base64_decode( $this->postResponse );
		$this->postDimensions   	= base64_decode( $this->postDimensions );


		if ( is_array( $this->supplementaryData ) ) {
			foreach ( $this->supplementaryData as $key => $value ) {
				$this->supplementaryData[ $key ] = base64_decode( $value );
			}
		}



		return $this;
	}

	/**
	 * @return string The class name
	 */
	public static function GetClassName() {
		return __CLASS__;
	}


}

