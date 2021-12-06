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
 * <p>
 * HPP Version and HPP Select Stored Card
 * </p>
 * <p>
 * Example usage:
 * <code><pre>
 * $hppRequest = new HppRequest();
 * $hppRequest
 *   ->addAmount("1001")
 *   ->addCurrency("EUR")
 *   ->addAccount("accountId")
 *   ->addMerchantId("merchantId")
 *   ->addAutoSettleFlag("1")
 *   ->addPayerExists("1")
 *   ->addPayerReference("payerRef")
 *   ->addHppSelectStoredCard("storedCardRef");
 * </pre></code>
 * </p>
 *
 * <p>
 * HPP Post Dimension and  HPP Post Response
 * </p>
 * <p>
 * Example usage:
 * <code><pre>
 * $hppRequest = new HppRequest();
 * $hppRequest
 *   ->addAmount("1001")
 *   ->addCurrency("EUR")
 *   ->addAccount("accountId")
 *   ->addMerchantId("merchantId")
 *   ->addAutoSettleFlag("1")
 *   ->addPayerExists("payerRef")
 *   ->addPayerReference("payerRef")
 *   ->addPostDimensions("https://www.example.com")
 *   ->addPostResponse("https://www.example.com");
 * </pre></code>
 * </p>
 * @author vicpada
 * @AssertHPP\OtbAmount
 * @AssertHPP\SupplementaryDataLength
 * @AssertHPP\SupplementaryDataPattern
 */
class HppRequest {

	/**
	 * @var String The merchant or client ID supplied by Realex Payments – note this is not the merchant number
	 * supplied by your bank.
	 *
	 * @Assert\Length(min = 1, max = 50, minMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_merchantId_size, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_merchantId_size)
	 * @Assert\NotBlank(message= com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_merchantId_size)
	 * @Assert\Regex(pattern="/^[a-zA-Z0-9\.]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_merchantId_pattern )
	 */
	private $merchantId;

	/**
	 * @var String The sub-account to use for this transaction. If not present, the default sub-account will be used.
	 *
	 * @Assert\Length(min = 0, max = 30, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_account_size)
	 * @Assert\Regex(pattern="/^[a-zA-Z0-9\s]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_account_pattern )
	 */
	private $account;

	/**
	 * @var String A unique alphanumeric id that’s used to identify the transaction. No spaces are allowed.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_orderId_size)
	 * @Assert\Regex(pattern="/^[a-zA-Z0-9_\-]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_orderId_pattern )
	 */
	private $orderId;

	/**
	 * @var String Total amount to authorise in the lowest unit of the currency – i.e. 100 euro would be entered as 10000.
	 * If there is no decimal in the currency (e.g. JPY Yen) then contact Realex Payments. No decimal points are allowed.
	 * Amount should be set to 0 for OTB transactions (i.e. where validate card only is set to 1).
	 *
	 * @Assert\Length(min = 1, max = 11, minMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_amount_size, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_amount_size)
	 * @Assert\NotBlank(message= com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_amount_size)
	 * @Assert\Regex(pattern="/^[0-9]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_amount_pattern )
	 */
	private $amount;

	/**
	 * @var String A three-letter currency code (Eg. EUR, GBP). A list of currency codes can be provided
	 * by your account manager.
	 *
	 * @Assert\Length(min = 3, max = 3, exactMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_currency_size)
	 * @Assert\NotBlank(message= com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_currency_size)
	 * @Assert\Regex(pattern="/^[a-zA-Z]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_currency_pattern )
	 */
	private $currency;

	/**
	 * @var String Date and time of the transaction. Entered in the following format: YYYYMMDDHHMMSS.
	 * Must be within 24 hours of the current time.
	 *
	 * @Assert\Length(min = 14, max = 14, exactMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_timestamp_size)
	 * @Assert\NotBlank(message= com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_timestamp_size)
	 * @Assert\Regex(pattern="/^[0-9]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_timestamp_pattern )
	 */
	private $timeStamp;

	/**
	 * @var String A digital signature generated using the SHA-1 algorithm.
	 *
	 * @Assert\Length(min = 40, max =40, exactMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_hash_size)
	 * @Assert\NotBlank(message= com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_hash_size)
	 * @Assert\Regex(pattern="/^[a-f0-9]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_hash_pattern )
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
	 * @Assert\Regex(pattern="/(?i)^on$|^off$|^$|^multi$|^1$|^0$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_autoSettleFlag_pattern )
	 *
	 */
	private $autoSettleFlag;

	/**
	 * @var String A freeform comment to describe the transaction.
	 * @Assert\Length(min = 0, max = 255, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_comment1_size, charset="ISO-8859-1")
	 * @Assert\Regex(pattern="/^[\s \x{0020}-\x{003B} \x{003D} \x{003F}-\x{007E} \x{00A1}-\x{00FF}\x{20AC}\x{201A}\x{0192}\x{201E}\x{2026}\x{2020}\x{2021}\x{02C6}\x{2030}\x{0160}\x{2039}\x{0152}\x{017D}\x{2018}\x{2019}\x{201C}\x{201D}\x{2022}\x{2013}\x{2014}\x{02DC}\x{2122}\x{0161}\x{203A}\x{0153}\x{017E}\x{0178}]*$/iu", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_comment1_pattern )
	 */
	private $commentOne;

	/**
	 * @var String A freeform comment to describe the transaction.
	 *
	 * @Assert\Length(min = 0, max = 255, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_comment2_size, charset="ISO-8859-1")
	 * @Assert\Regex(pattern="/^[\s \x{0020}-\x{003B} \x{003D} \x{003F}-\x{007E} \x{00A1}-\x{00FF}\x{20AC}\x{201A}\x{0192}\x{201E}\x{2026}\x{2020}\x{2021}\x{02C6}\x{2030}\x{0160}\x{2039}\x{0152}\x{017D}\x{2018}\x{2019}\x{201C}\x{201D}\x{2022}\x{2013}\x{2014}\x{02DC}\x{2122}\x{0161}\x{203A}\x{0153}\x{017E}\x{0178}]*$/iu", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_comment2_pattern )
	 */
	private $commentTwo;

	/**
	 * @var String Used to signify whether or not you want a Transaction Suitability Score for this transaction.
	 * Can be "0" for no and "1" for yes.
	 *
	 * @Assert\Length(min = 0, max = 1, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_returnTss_size)
	 * @Assert\Regex(pattern="/^[01]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_returnTss_pattern )
	 */
	private $returnTss;

	/**
	 * @var String The postcode or ZIP of the shipping address.
	 *
	 * @Assert\Length(min = 0, max = 30, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_shippingCode_size)
	 * @Assert\Regex(pattern="/^[A-Za-z0-9\,\.\-\/\| ]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_shippingCode_pattern )
	 */
	private $shippingCode;

	/**
	 * @var String The country of the shipping address.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_shippingCountry_size)
	 * @Assert\Regex(pattern="/^[A-Za-z0-9\,\.\- ]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_shippingCountry_pattern )
	 */
	private $shippingCountry;

	/**
	 * @var String The postcode or ZIP of the billing address.
	 *
	 * @Assert\Length(min = 0, max = 60, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_billingCode_size)
	 * @Assert\Regex(pattern="/^[A-Za-z0-9\,\.\-\/\| ]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_billingCode_pattern )
	 */
	private $billingCode;

	/**
	 * @var String The country of the billing address.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_billingCountry_size)
	 * @Assert\Regex(pattern="/^[A-Za-z0-9\,\.\- ]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_billingCountry_pattern )
	 */
	private $billingCountry;

	/**
	 * @var String The customer number of the customer. You can send in any additional information about
	 * the transaction in this field, which will be visible under the transaction in the RealControl application.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_customerNumber_size)
	 * @Assert\Regex(pattern="/^[a-zA-Z0-9\.\_\-\,\+\@ \s]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_customerNumber_pattern )
	 */
	private $customerNumber;

	/**
	 * @var String A variable reference also associated with this customer. You can send in any additional
	 * information about the transaction in this field, which will be visible under the transaction in
	 * the RealControl application.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_variableReference_size)
	 * @Assert\Regex(pattern="/^[a-zA-Z0-9\.\_\-\,\+\@ \s]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_variableReference_pattern )
	 */
	private $variableReference;

	/**
	 * @var String A product id associated with this product. You can send in any additional information about
	 * the transaction in this field, which will be visible under the transaction in the RealControl application.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_productId_size)
	 * @Assert\Regex(pattern="/^[a-zA-Z0-9\.\_\-\,\+\@ \s]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_productId_pattern )
	 */
	private $productId;

	/**
	 * @var String Used to set what language HPP is displayed in. Currently HPP is available in English, Spanish and
	 * German, with other languages to follow. If the field is not sent in, the default language is the language
	 * that is set in your account configuration. This can be set by your account manager.
	 *
	 * @Assert\Regex(pattern="/^[a-zA-Z]{2}$|^[a-zA-Z]{0}$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_language_pattern )
	 */
	private $language;

	/**
	 * @var String Used to set what text is displayed on the payment button for card transactions.
	 * If this field is not sent in, "Pay Now" is displayed on the button by default.
	 *
	 * @Assert\Length(min = 0, max = 25, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_cardPaymentButtonText_size)
	 * @Assert\Regex(pattern = "/^[\x{00C0}\x{00C1}\x{00C2}\x{00C3}\x{00C4}\x{00C5}\x{00C6}\x{00C7}\x{00C8}\x{00C9}\x{00CA}\x{00CB}\x{00CC}\x{00CD}\x{00CE}\x{00CF}\x{00D0}\x{00D1}\x{00D2}\x{00D3}\x{00D4}\x{00D5}\x{00D6}\x{00D7}\x{00D8}\x{00D9}\x{00DA}\x{00DB}\x{00DC}\x{00DD}\x{00DE}\x{00DF}\x{00E0}\x{00E1}\x{00E2}\x{00E3}\x{00E4}\x{00E5}\x{00E6}\x{00E7}\x{00E8}\x{00E9}\x{00EA}\x{00EB}\x{00EC}\x{00ED}\x{00EE}\x{00EF}\x{00F0}\x{00F1}\x{00F2}\x{00F3}\x{00F4}\x{00F5}\x{00F6}\x{00F7}\x{00F8}\x{00A4}\x{00F9}\x{00FA}\x{00FB}\x{00FC}\x{00FD}\x{00FE}\x{00FF}\x{0152}\x{017D}\x{0161}\x{0153}\x{017E}\x{0178}\x{00A5}a-zA-Z0-9\'\,\+\x{0022}\.\_\-\&\/\@\!\?\%\()\*\:\x{00A3}\$\&\x{20AC}\#\[\]\|\=\\\x{201C}\x{201D}\x{201C} ]*$/iu" , message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_cardPaymentButtonText_pattern )
	 */
	private $cardPaymentButtonText;


	/**
	 * @var string Enable card storage.
	 *
	 * @Assert\Length(min = 0, max = 1, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_cardStorageEnable_size)
	 * @Assert\Regex(pattern = "/^[10]*$/" , message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_cardStorageEnable_pattern )
	 */
	private $cardStorageEnable;

	/**
	 * @var string Offer to save the card.
	 *
	 * @Assert\Length(min = 0, max = 1, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_offerSaveCard_size)
	 * @Assert\Regex(pattern = "/^[10]*$/" , message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_offerSaveCard_pattern )
	 */
	private $offerSaveCard;

	/**
	 * @var string The payer reference.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_payerReference_size)
	 * @Assert\Regex(pattern = "/^[A-Za-z0-9\_\-\\ ]*$/" , message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_payerReference_pattern )
	 */
	private $payerReference;

	/**
	 * @var string The payment reference.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_paymentReference_size)
	 * @Assert\Regex(pattern = "/^[A-Za-z0-9\_\-]*$/" , message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_paymentReference_pattern )
	 */
	private $paymentReference;

	/**
	 * @var string Flag to indicate if the payer exists.
	 *
	 * @Assert\Length(min = 0, max = 1, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_payerExists_size)
	 * @Assert\Regex(pattern = "/^[102]*$/" , message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_payerExists_pattern )
	 */
	private $payerExists;

	/**
	 * @var string[] Supplementary data to be sent to Realex Payments. This will be returned in the HPP response.
	 * Fields will be 255 char max
	 */
	private $supplementaryData = array();

	/**
	 * @var string Used to identify an OTB transaction.
	 *
	 * @Assert\Length(min = 0, max = 1, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_validateCardOnly_size)
	 * @Assert\Regex(pattern="/^[01]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_validateCardOnly_pattern )
	 */
	private $validateCardOnly;

	/**
	 * @var string Transaction level configuration to enable/disable a DCC request.
	 * (Only if the merchant is configured).
	 *
	 * @Assert\Length(min = 0, max = 1, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_dccEnable_size)
	 * @Assert\Regex(pattern="/^[01]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_dccEnable_pattern )
	 */
	private $dccEnable;

	/**
	 * @var string Used to indicate the SDK version. Can only have the value 1 or 2. Passing 2 enables the new skin for the HPP.
	 * It also allows HPP_SELECT_STORED_CARD to be sent.
	 *
	 * @Assert\Length(min = 0, max = 1, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_hppVersion_size)
	 * @Assert\Regex(pattern="/^[1-2]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_hppVersion_pattern )
	 */
	private $hppVersion;

	/**
	 * @var string Must contain the Payer reference of the customer whose cards the merchant wishes
	 * to display on the HPP. If sent correctly, all of the customer's saved cards will be displayed and they can choose
	 * which one they wish to complete the payment with.
	 *
	 * @Assert\Length(min = 0, max = 50, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_hppSelectStoredCard_size)
	 * @Assert\Regex(pattern="/^[A-Za-z0-9\_\-\\ ]*$/", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_hppSelectStoredCard_pattern )
	 */
	private $hppSelectStoredCard;

	/**
	 * @var string This field should contain the domain of the page hosting the iFrame calling HPP. If sent correctly,
	 * every time the height or width of the card form changes (e.g. an error message is displayed),
	 * the HPP will send this back as a JSON string to the parent iFrame.
	 * This is to facilitate developers who wish to resize their iFrame accordingly on increases or decreases of the HPP form’s size.
	 * @Assert\Length(min = 0, max = 255, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_postDimensions_size, charset="ISO-8859-1")
	 * @Assert\Regex(pattern="/^[\s \x{0020}-\x{003B} \x{003D} \x{003F}-\x{007E} \x{00A1}-\x{00FF}\x{20AC}\x{201A}\x{0192}\x{201E}\x{2026}\x{2020}\x{2021}\x{02C6}\x{2030}\x{0160}\x{2039}\x{0152}\x{017D}\x{2018}\x{2019}\x{201C}\x{201D}\x{2022}\x{2013}\x{2014}\x{02DC}\x{2122}\x{0161}\x{203A}\x{0153}\x{017E}\x{0178}]*$/iu", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_postDimensions_pattern )

	 */
	private $postDimensions ;

	/**
	 * @var string This field should contain the domain of the page hosting the iFrame calling HPP. If sent correctly,
	 * when the transaction is complete the HPP will send the response as a
	 * Base64 encoded JSON string to the parent iFrame.
	 * This is to facilitate developers who wish to not have to rely on a Response URL
	 * to accept the transaction response and would prefer to have the parent iFrame capture it
	 *
	 * @Assert\Length(min = 0, max = 255, maxMessage = com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_postResponse_size, charset="ISO-8859-1")
	 * @Assert\Regex(pattern="/^[\s \x{0020}-\x{003B} \x{003D} \x{003F}-\x{007E} \x{00A1}-\x{00FF}\x{20AC}\x{201A}\x{0192}\x{201E}\x{2026}\x{2020}\x{2021}\x{02C6}\x{2030}\x{0160}\x{2039}\x{0152}\x{017D}\x{2018}\x{2019}\x{201C}\x{201D}\x{2022}\x{2013}\x{2014}\x{02DC}\x{2122}\x{0161}\x{203A}\x{0153}\x{017E}\x{0178}]*$/iu", message=com\realexpayments\hpp\sdk\validators\ValidationMessages::hppRequest_postResponse_pattern )
	 */
	private $postResponse;

	/**
	 * @var string Customer's email address, including the full domain name. The field must be submitted in the form
	 * `name@host.domain` (for example, `james.mason@example.com`).
	 * 
	 * European merchants: mandatory for SCA.
	 */
	private $customerEmailAddress;

	/**
	 * @var string The mobile phone number provided by the Cardholder. Should be in format `CountryCallingCode|Number`
	 * (for example, `1|123456789`).
	 * 
	 * European merchants: mandatory for SCA if captured by your application or website. Global Payments recommend you send at least one phone number (Mobile, Home or Work).
	 */
	private $customerMobilePhoneNumber;

	/**
	 * @var string First line of the customer's billing address.
	 * 
	 * European merchants: mandatory for SCA.
	 */
	private $billingAddressLine1;

	/**
	 * @var string Second line of the customer's billing address. Can be submitted as blank if not relevant for the particular customer.
	 * 
	 * European merchants: mandatory for SCA.
	 */
	private $billingAddressLine2;

	/**
	 * @var string Third line of the customer's billing address. Can be submitted as blank if not relevant for the particular customer.
	 * 
	 * European merchants: mandatory for SCA.
	 */
	private $billingAddressLine3;

	/**
	 * @var string The city of the customer's billing address.
	 * 
	 * European merchants: mandatory for SCA.
	 */
	private $billingCity;

	/**
	 * @var string The state of the customer's billing address. Should be the country subdivision code defined in ISO 3166-2.
	 * 
	 * European merchants: if state applicable for the billing address country, required for SCA.
	 */ 
	private $billingState;

	/**
	 * @var string ZIP or other postal code customer's billing address.
	 * 
	 * European merchants: mandatory for SCA.
	 */
	private $billingPostalCode;

	/**
	 * @var string The country of the customer's billing address. ISO 3166-1 numeric three-digit country code.
	 * 
	 * European merchants: mandatory for SCA.
	 */
	private $billingCountryCode;

	/**
	 * @var string First line of the customer's shipping address.
	 * 
	 * European merchants: optional for SCA.
	 */
	private $shippingAddressLine1;

	/**
	 * @var string Second line of the customer's shipping address.
	 * 
	 * European merchants: optional for SCA.
	 */
	private $shippingAddressLine2;

	/**
	 * @var string Third line of the customer's shipping address.
	 * 
	 * European merchants: optional for SCA.
	 */
	private $shippingAddressLine3;

	/**
	 * @var string The city of the customer's shipping address.
	 * 
	 * European merchants: optional for SCA.
	 */
	private $shippingCity;

	/**
	 * @var string The state of the customer's shipping address. Should be the country subdivision code defined in ISO 3166-2.
	 * 
	 * European merchants: if applicable for the shipping address country, optional for SCA.
	 */
	private $shippingState;

	/**
	 * @var string ZIP or other postal code customer's shipping address.
	 * 
	 * European merchants: optional for SCA.
	 */
	private $shippingPostalCode;

	/**
	 * @var string The country of the customer's shipping address. ISO 3166-1 numeric three-digit country code.
	 * 
	 * European merchants: optional for SCA.
	 */
	private $shippingCountryCode;

	/**
	 * @var boolean Indicates whether the shipping address matches the billing address. Allowed values:
	 * 
	 * `TRUE` - Shipping Address matches Billing Address
	 * `FALSE` - Shipping Address does not match Billing Address
	 * 
	 * European merchants: optional for SCA.
	 */
	private $shippingAddressMatchIndicator;

	/**
	 * @var string Indicates whether a challenge is requested for this transaction. The Issuer may override whatever preference is specified in this field. Allowed values:
	 * 
	 * `NO_PREFERENCE` - No preference as to whether the customer is challenged
	 * `NO_CHALLENGE_REQUESTED` - Preference is for the customer not be challenged.
	 * `CHALLENGE_PREFERRED` - Preference is for the customer to be challenged.
	 * `CHALLENGE_MANDATED` - A challenge is required for the transaction to be authorised due to local/regional mandates or other variables.
	 * 
	 * European merchants: optional for SCA.
	 */
	private $challengeRequestIndicator;
	
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
	 * @return string
	 */
	public function getHppVersion(){
		return $this->hppVersion ;

	}

	/**
	 * Helper method for adding the Hpp Select Stored Card
	 *
	 * @param string $hppSelectStoredCard
	 *
	 * @return HppRequest
	 */
	public function addHppSelectStoredCard( $hppSelectStoredCard ){
		$this->hppSelectStoredCard = $hppSelectStoredCard;

		return $this;
	}

	/**
	 * Helper method for setting the Hpp Select Stored Card
	 *
	 * @param string $hppSelectStoredCard
	 *
	 * @return void
	 */
	public function setHppSelectStoredCard( $hppSelectStoredCard ){
		$this->hppSelectStoredCard = $hppSelectStoredCard;
	}

	/**
	 * Helper method for adding the Hpp Select Stored Card
	 *
	 * @return string
	 */
	public function getHppSelectStoredCard( ){
		return $this->hppSelectStoredCard ;

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
	 * @return string
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
	 * @return string
	 */
	public function getPostResponse(){
		return $this->postResponse ;

	}

	/**
	 * Getter for customerEmailAddress
	 *
	 * @return string
	 */
	public function getCustomerEmailAddress() {
		return $this->customerEmailAddress;
	}

	/**
	 * Setter for customerEmailAddress
	 * 
	 * @param string $customerEmailAddress
	 */
	public function setCustomerEmailAddress( $customerEmailAddress ) {
		$this->customerEmailAddress = $customerEmailAddress;
	}

	/**
	 * Getter for customerMobilePhoneNumber
	 *
	 * @return string
	 */
	public function getCustomerMobilePhoneNumber() {
		return $this->customerMobilePhoneNumber;
	}

	/**
	 * Setter for customerMobilePhoneNumber
	 * 
	 * @param string $customerMobilePhoneNumber
	 */
	public function setCustomerMobilePhoneNumber( $customerMobilePhoneNumber ) {
		$this->customerMobilePhoneNumber = $customerMobilePhoneNumber;
	}

	/**
	 * Getter for billingAddressLine1
	 *
	 * @return string
	 */
	public function getBillingAddressLine1() {
		return $this->billingAddressLine1;
	}

	/**
	 * Setter for billingAddressLine1
	 * 
	 * @param string $billingAddressLine1
	 */
	public function setBillingAddressLine1( $billingAddressLine1 ) {
		$this->billingAddressLine1 = $billingAddressLine1;
	}

	/**
	 * Getter for billingAddressLine2
	 *
	 * @return string
	 */
	public function getBillingAddressLine2() {
		return $this->billingAddressLine2;
	}

	/**
	 * Setter for billingAddressLine2
	 * 
	 * @param string $billingAddressLine2
	 */
	public function setBillingAddressLine2( $billingAddressLine2 ) {
		$this->billingAddressLine2 = $billingAddressLine2;
	}

	/**
	 * Getter for billingAddressLine3
	 *
	 * @return string
	 */
	public function getBillingAddressLine3() {
		return $this->billingAddressLine3;
	}

	/**
	 * Setter for billingAddressLine3
	 * 
	 * @param string $billingAddressLine3
	 */
	public function setBillingAddressLine3( $billingAddressLine3 ) {
		$this->billingAddressLine3 = $billingAddressLine3;
	}

	/**
	 * Getter for billingCity
	 *
	 * @return string
	 */
	public function getBillingCity() {
		return $this->billingCity;
	}

	/**
	 * Setter for billingCity
	 * 
	 * @param string $billingCity
	 */
	public function setBillingCity( $billingCity ) {
		$this->billingCity = $billingCity;
	}

	/**
	 * Getter for billingState
	 *
	 * @return string
	 */
	public function getBillingState() {
		return $this->billingState;
	}

	/**
	 * Setter for billingState
	 * 
	 * @param string $billingState
	 */
	public function setBillingState( $billingState ) {
		$this->billingState = $billingState;
	}

	/**
	 * Getter for billingPostalCode
	 *
	 * @return string
	 */
	public function getBillingPostalCode() {
		return $this->billingPostalCode;
	}

	/**
	 * Setter for billingPostalCode
	 * 
	 * @param string $billingPostalCode
	 */
	public function setBillingPostalCode( $billingPostalCode ) {
		$this->billingPostalCode = $billingPostalCode;
	}

	/**
	 * Getter for billingCountryCode
	 *
	 * @return string
	 */
	public function getBillingCountryCode() {
		return $this->billingCountryCode;
	}

	/**
	 * Setter for billingCountryCode
	 * 
	 * @param string $billingCountryCode
	 */
	public function setBillingCountryCode( $billingCountryCode ) {
		$this->billingCountryCode = $billingCountryCode;
	}

	/**
	 * Getter for shippingAddressLine1
	 *
	 * @return string
	 */
	public function getShippingAddressLine1() {
		return $this->shippingAddressLine1;
	}

	/**
	 * Setter for shippingAddressLine1
	 * 
	 * @param string $shippingAddressLine1
	 */
	public function setShippingAddressLine1( $shippingAddressLine1 ) {
		$this->shippingAddressLine1 = $shippingAddressLine1;
	}

	/**
	 * Getter for shippingAddressLine2
	 *
	 * @return string
	 */
	public function getShippingAddressLine2() {
		return $this->shippingAddressLine2;
	}

	/**
	 * Setter for shippingAddressLine2
	 * 
	 * @param string $shippingAddressLine2
	 */
	public function setShippingAddressLine2( $shippingAddressLine2 ) {
		$this->shippingAddressLine2 = $shippingAddressLine2;
	}

	/**
	 * Getter for shippingAddressLine3
	 *
	 * @return string
	 */
	public function getShippingAddressLine3() {
		return $this->shippingAddressLine3;
	}

	/**
	 * Setter for shippingAddressLine3
	 * 
	 * @param string $shippingAddressLine3
	 */
	public function setShippingAddressLine3( $shippingAddressLine3 ) {
		$this->shippingAddressLine3 = $shippingAddressLine3;
	}

	/**
	 * Getter for shippingCity
	 *
	 * @return string
	 */
	public function getShippingCity() {
		return $this->shippingCity;
	}

	/**
	 * Setter for shippingCity
	 * 
	 * @param string $shippingCity
	 */
	public function setShippingCity( $shippingCity ) {
		$this->shippingCity = $shippingCity;
	}

	/**
	 * Getter for shippingState
	 *
	 * @return string
	 */
	public function getShippingState() {
		return $this->shippingState;
	}

	/**
	 * Setter for shippingState
	 * 
	 * @param string $shippingState
	 */
	public function setShippingState( $shippingState ) {
		$this->shippingState = $shippingState;
	}

	/**
	 * Getter for shippingPostalCode
	 *
	 * @return string
	 */
	public function getShippingPostalCode() {
		return $this->shippingPostalCode;
	}

	/**
	 * Setter for shippingPostalCode
	 * 
	 * @param string $shippingPostalCode
	 */
	public function setShippingPostalCode( $shippingPostalCode ) {
		$this->shippingPostalCode = $shippingPostalCode;
	}

	/**
	 * Getter for shippingCountryCode
	 *
	 * @return string
	 */
	public function getShippingCountryCode() {
		return $this->shippingCountryCode;
	}

	/**
	 * Setter for shippingCountryCode
	 * 
	 * @param string $shippingCountryCode
	 */
	public function setShippingCountryCode( $shippingCountryCode ) {
		$this->shippingCountryCode = $shippingCountryCode;
	}

	/**
	 * Getter for shippingAddressMatchIndicator
	 *
	 * @return boolean
	 */
	public function getShippingAddressMatchIndicator() {
		return $this->shippingAddressMatchIndicator;
	}

	/**
	 * Setter for shippingAddressMatchIndicator
	 * 
	 * @param boolean $shippingAddressMatchIndicator
	 */
	public function setShippingAddressMatchIndicator( $shippingAddressMatchIndicator ) {
		$this->shippingAddressMatchIndicator = (bool)$shippingAddressMatchIndicator;
	}

	/**
	 * Getter for challengeRequestIndicator
	 *
	 * @return string
	 */
	public function getChallengeRequestIndicator() {
		return $this->challengeRequestIndicator;
	}

	/**
	 * Setter for challengeRequestIndicator
	 * 
	 * @param string $challengeRequestIndicator
	 */
	public function setChallengeRequestIndicator( $challengeRequestIndicator ) {
		$this->challengeRequestIndicator = $challengeRequestIndicator;
	}

	/**
	 * Helper method for setting customerEmailAddress
	 * 
	 * @param string $customerEmailAddress
	 * @return HppRequest
	 */
	public function addCustomerEmailAddress( $customerEmailAddress ) {
		$this->setCustomerEmailAddress($customerEmailAddress);
		return $this;
	}

	/**
	 * Helper method for setting customerMobilePhoneNumber
	 * 
	 * @param string $customerMobilePhoneNumber
	 * @return HppRequest
	 */
	public function addCustomerMobilePhoneNumber( $customerMobilePhoneNumber ) {
		$this->setCustomerMobilePhoneNumber($customerMobilePhoneNumber);
		return $this;
	}

	/**
	 * Helper method for setting billingAddressLine1
	 * 
	 * @param string $billingAddressLine1
	 * @return HppRequest
	 */
	public function addBillingAddressLine1( $billingAddressLine1 ) {
		$this->setBillingAddressLine1($billingAddressLine1);
		return $this;
	}

	/**
	 * Helper method for setting billingAddressLine2
	 * 
	 * @param string $billingAddressLine2
	 * @return HppRequest
	 */
	public function addBillingAddressLine2( $billingAddressLine2 ) {
		$this->setBillingAddressLine2($billingAddressLine2);
		return $this;
	}

	/**
	 * Helper method for setting billingAddressLine3
	 * 
	 * @param string $billingAddressLine3
	 * @return HppRequest
	 */
	public function addBillingAddressLine3( $billingAddressLine3 ) {
		$this->setBillingAddressLine3($billingAddressLine3);
		return $this;
	}

	/**
	 * Helper method for setting billingCity
	 * 
	 * @param string $billingCity
	 * @return HppRequest
	 */
	public function addBillingCity( $billingCity ) {
		$this->setBillingCity($billingCity);
		return $this;
	}

	/**
	 * Helper method for setting billingState
	 * 
	 * @param string $billingState
	 * @return HppRequest
	 */
	public function addBillingState( $billingState ) {
		$this->setBillingState($billingState);
		return $this;
	}

	/**
	 * Helper method for setting billingPostalCode
	 * 
	 * @param string $billingPostalCode
	 * @return HppRequest
	 */
	public function addBillingPostalCode( $billingPostalCode ) {
		$this->setBillingPostalCode($billingPostalCode);
		return $this;
	}

	/**
	 * Helper method for setting billingCountryCode
	 * 
	 * @param string $billingCountryCode
	 * @return HppRequest
	 */
	public function addBillingCountryCode( $billingCountryCode ) {
		$this->setBillingCountryCode($billingCountryCode);
		return $this;
	}

	/**
	 * Helper method for setting shippingAddressLine1
	 * 
	 * @param string $shippingAddressLine1
	 * @return HppRequest
	 */
	public function addShippingAddressLine1( $shippingAddressLine1 ) {
		$this->setShippingAddressLine1($shippingAddressLine1);
		return $this;
	}

	/**
	 * Helper method for setting shippingAddressLine2
	 * 
	 * @param string $shippingAddressLine2
	 * @return HppRequest
	 */
	public function addShippingAddressLine2( $shippingAddressLine2 ) {
		$this->setShippingAddressLine2($shippingAddressLine2);
		return $this;
	}

	/**
	 * Helper method for setting shippingAddressLine3
	 * 
	 * @param string $shippingAddressLine3
	 * @return HppRequest
	 */
	public function addShippingAddressLine3( $shippingAddressLine3 ) {
		$this->setShippingAddressLine3($shippingAddressLine3);
		return $this;
	}

	/**
	 * Helper method for setting shippingCity
	 * 
	 * @param string $shippingCity
	 * @return HppRequest
	 */
	public function addShippingCity( $shippingCity ) {
		$this->setShippingCity($shippingCity);
		return $this;
	}

	/**
	 * Helper method for setting shippingState
	 * 
	 * @param string $shippingState
	 * @return HppRequest
	 */
	public function addShippingState( $shippingState ) {
		$this->setShippingState($shippingState);
		return $this;
	}

	/**
	 * Helper method for setting shippingPostalCode
	 * 
	 * @param string $shippingPostalCode
	 * @return HppRequest
	 */
	public function addShippingPostalCode( $shippingPostalCode ) {
		$this->setShippingPostalCode($shippingPostalCode);
		return $this;
	}

	/**
	 * Helper method for setting shippingCountryCode
	 * 
	 * @param string $shippingCountryCode
	 * @return HppRequest
	 */
	public function addShippingCountryCode( $shippingCountryCode ) {
		$this->setShippingCountryCode($shippingCountryCode);
		return $this;
	}

	/**
	 * Helper method for setting shippingAddressMatchIndicator
	 * 
	 * @param boolean $shippingAddressMatchIndicator
	 * @return HppRequest
	 */
	public function addShippingAddressMatchIndicator( $shippingAddressMatchIndicator ) {
		$this->setShippingAddressMatchIndicator($shippingAddressMatchIndicator);
		return $this;
	}

	/**
	 * Helper method for setting challengeRequestIndicator
	 * 
	 * @param string $challengeRequestIndicator
	 * @return HppRequest
	 */
	public function addChallengeRequestIndicator( $challengeRequestIndicator ) {
		$this->setChallengeRequestIndicator($challengeRequestIndicator);
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
		$payerReference   = null == $this->payerReference ? "" : $this->payerReference;
		$paymentReference = null == $this->paymentReference ? "" : $this->paymentReference;
		$hppSelectStoredCard = null == $this->hppSelectStoredCard ? "" : $this->hppSelectStoredCard;


        // Override payerRef with hppSelectStoredCard if present.
		$payRefORStoredCard =  empty($hppSelectStoredCard) ?  $payerReference : $hppSelectStoredCard;

        //create String to hash
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
		$this->hppSelectStoredCard    = base64_encode( $this->hppSelectStoredCard );
		$this->postResponse   		 = base64_encode( $this->postResponse );
		$this->postDimensions   	 = base64_encode( $this->postDimensions );
		$this->customerEmailAddress = base64_encode( $this->customerEmailAddress );
		$this->customerMobilePhoneNumber = base64_encode( $this->customerMobilePhoneNumber );
		$this->billingAddressLine1 = base64_encode( $this->billingAddressLine1 );
		$this->billingAddressLine2 = base64_encode( $this->billingAddressLine2 );
		$this->billingAddressLine3 = base64_encode( $this->billingAddressLine3 );
		$this->billingCity = base64_encode( $this->billingCity );
		$this->billingState = base64_encode( $this->billingState );
		$this->billingPostalCode = base64_encode( $this->billingPostalCode );
		$this->billingCountryCode = base64_encode( $this->billingCountryCode );
		$this->shippingAddressLine1 = base64_encode( $this->shippingAddressLine1 );
		$this->shippingAddressLine2 = base64_encode( $this->shippingAddressLine2 );
		$this->shippingAddressLine3 = base64_encode( $this->shippingAddressLine3 );
		$this->shippingCity = base64_encode( $this->shippingCity );
		$this->shippingState = base64_encode( $this->shippingState );
		$this->shippingPostalCode = base64_encode( $this->shippingPostalCode );
		$this->shippingCountryCode = base64_encode( $this->shippingCountryCode );
		$this->shippingAddressMatchIndicator = base64_encode( $this->shippingAddressMatchIndicator );
		$this->challengeRequestIndicator = base64_encode( $this->challengeRequestIndicator );

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
		$this->hppSelectStoredCard   	= base64_decode( $this->hppSelectStoredCard );
		$this->postResponse   		= base64_decode( $this->postResponse );
		$this->postDimensions   	= base64_decode( $this->postDimensions );
		$this->customerEmailAddress = base64_decode( $this->customerEmailAddress );
		$this->customerMobilePhoneNumber = base64_decode( $this->customerMobilePhoneNumber );
		$this->billingAddressLine1 = base64_decode( $this->billingAddressLine1 );
		$this->billingAddressLine2 = base64_decode( $this->billingAddressLine2 );
		$this->billingAddressLine3 = base64_decode( $this->billingAddressLine3 );
		$this->billingCity = base64_decode( $this->billingCity );
		$this->billingState = base64_decode( $this->billingState );
		$this->billingPostalCode = base64_decode( $this->billingPostalCode );
		$this->billingCountryCode = base64_decode( $this->billingCountryCode );
		$this->shippingAddressLine1 = base64_decode( $this->shippingAddressLine1 );
		$this->shippingAddressLine2 = base64_decode( $this->shippingAddressLine2 );
		$this->shippingAddressLine3 = base64_decode( $this->shippingAddressLine3 );
		$this->shippingCity = base64_decode( $this->shippingCity );
		$this->shippingState = base64_decode( $this->shippingState );
		$this->shippingPostalCode = base64_decode( $this->shippingPostalCode );
		$this->shippingCountryCode = base64_decode( $this->shippingCountryCode );
		$this->shippingAddressMatchIndicator = base64_decode( $this->shippingAddressMatchIndicator );
		$this->challengeRequestIndicator = base64_decode( $this->challengeRequestIndicator );


		if ( is_array( $this->supplementaryData ) ) {
			foreach ( $this->supplementaryData as $key => $value ) {
				$this->supplementaryData[ $key ] = base64_decode( $value );
			}
		}

		return $this;
	}

	/**
	 * Format (non-encoded) request, remove null values
	 *
	 * @param string $charSet
	 *
	 * @return HppRequest
	 */
	public function formatRequest($charSet)
	{
	    $this->account = $this->nullToEmptyString($this->account);
	    $this->amount = $this->nullToEmptyString($this->amount);
	    $this->autoSettleFlag = $this->nullToEmptyString($this->autoSettleFlag);
	    $this->billingCode = $this->nullToEmptyString($this->billingCode);
	    $this->billingCountry = $this->nullToEmptyString($this->billingCountry);
	    $this->cardPaymentButtonText = $this->nullToEmptyString($this->cardPaymentButtonText);
	    $this->cardStorageEnable = $this->nullToEmptyString($this->cardStorageEnable);
	    $this->commentOne = $this->nullToEmptyString($this->commentOne);
	    $this->commentTwo = $this->nullToEmptyString($this->commentTwo);
	    $this->currency = $this->nullToEmptyString($this->currency);
	    $this->customerNumber = $this->nullToEmptyString($this->customerNumber);
	    $this->hash = $this->nullToEmptyString($this->hash);
	    $this->language = $this->nullToEmptyString($this->language);
	    $this->merchantId = $this->nullToEmptyString($this->merchantId);
	    $this->offerSaveCard = $this->nullToEmptyString($this->offerSaveCard);
	    $this->orderId = $this->nullToEmptyString($this->orderId);
	    $this->payerExists = $this->nullToEmptyString($this->payerExists);
	    $this->payerReference = $this->nullToEmptyString($this->payerReference);
	    $this->paymentReference = $this->nullToEmptyString($this->paymentReference);
	    $this->productId = $this->nullToEmptyString($this->productId);
	    $this->returnTss = $this->nullToEmptyString($this->returnTss);
	    $this->shippingCode = $this->nullToEmptyString($this->shippingCode);
	    $this->shippingCountry = $this->nullToEmptyString($this->shippingCountry);
	    $this->timeStamp = $this->nullToEmptyString($this->timeStamp);
	    $this->variableReference = $this->nullToEmptyString($this->variableReference);
	    $this->validateCardOnly = $this->nullToEmptyString($this->validateCardOnly);
	    $this->dccEnable = $this->nullToEmptyString($this->dccEnable);
	    $this->hppVersion = $this->nullToEmptyString($this->hppVersion);
	    $this->hppSelectStoredCard = $this->nullToEmptyString($this->hppSelectStoredCard);
	    $this->postResponse = $this->nullToEmptyString($this->postResponse);
			$this->postDimensions = $this->nullToEmptyString($this->postDimensions);
			$this->customerEmailAddress = $this->nullToEmptyString($this->customerEmailAddress);
			$this->customerMobilePhoneNumber = $this->nullToEmptyString($this->customerMobilePhoneNumber);
			$this->billingAddressLine1 = $this->nullToEmptyString($this->billingAddressLine1);
			$this->billingAddressLine2 = $this->nullToEmptyString($this->billingAddressLine2);
			$this->billingAddressLine3 = $this->nullToEmptyString($this->billingAddressLine3);
			$this->billingCity = $this->nullToEmptyString($this->billingCity);
			$this->billingState = $this->nullToEmptyString($this->billingState);
			$this->billingPostalCode = $this->nullToEmptyString($this->billingPostalCode);
			$this->billingCountryCode = $this->nullToEmptyString($this->billingCountryCode);
			$this->shippingAddressLine1 = $this->nullToEmptyString($this->shippingAddressLine1);
			$this->shippingAddressLine2 = $this->nullToEmptyString($this->shippingAddressLine2);
			$this->shippingAddressLine3 = $this->nullToEmptyString($this->shippingAddressLine3);
			$this->shippingCity = $this->nullToEmptyString($this->shippingCity);
			$this->shippingState = $this->nullToEmptyString($this->shippingState);
			$this->shippingPostalCode = $this->nullToEmptyString($this->shippingPostalCode);
			$this->shippingCountryCode = $this->nullToEmptyString($this->shippingCountryCode);
			$this->shippingAddressMatchIndicator = $this->nullToEmptyString($this->shippingAddressMatchIndicator);
			$this->challengeRequestIndicator = $this->nullToEmptyString($this->challengeRequestIndicator);
	    
	    if (is_array($this->supplementaryData)) {
	        foreach ($this->supplementaryData as $key => $value) {
	            $this->supplementaryData[$key] = $this->nullToEmptyString($value);
	        }
	    }
	    
	    return $this;
	}
	
	/**
	 * Convert null values to empty strings
	 *
	 * @param string request $parameter
	 *           
	 * @return $parameter
	 */
	public function nullToEmptyString($parameter)
	{
	    if (is_null($parameter)) {
	        $parameter = "";
	    }
	    
	    return $parameter;
	}
	
	/**
	 * @return string The class name
	 */
	public static function GetClassName() {
		return __CLASS__;
	}


}