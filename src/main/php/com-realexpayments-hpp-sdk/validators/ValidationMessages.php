<?php


namespace com\realexpayments\hpp\sdk\validators;


class ValidationMessages {

	const hppRequest_merchantId_size = "Merchant ID is required and must be between 1 and 50 characters";
	const hppRequest_merchantId_pattern = "Merchant ID must only contain alphanumeric characters";

	const hppRequest_account_size = "Account must be 30 characters or less";
	const hppRequest_account_pattern = "Account must only contain alphanumeric characters";

	const hppRequest_orderId_size = "Order ID must be less than 50 characters in length";
	const hppRequest_orderId_pattern = "Order ID must only contain alphanumeric characters, dash and underscore";

	const hppRequest_amount_size = "Amount is required and must be 11 characters or less";
	const hppRequest_amount_pattern = "Amount must only include numeric characters";
	const hppRequest_amount_otb = "Amount must be 0 for OTB transactions (where validate card only set to 1)";

	const hppRequest_currency_size = "Currency is required and must be 3 characters in length";
	const hppRequest_currency_pattern = "Currency must only consist of alphabetic characters";

	const hppRequest_timestamp_size = "Time stamp is required and must be 14 characters in length";
	const hppRequest_timestamp_pattern = "Time stamp must be in YYYYMMDDHHMMSS format";

	const hppRequest_hash_size = "Security hash must be 40 characters in length";
	const hppRequest_hash_pattern = "Security hash must only contain numeric and a-f characters";

	const hppRequest_autoSettleFlag_pattern = "Auto settle flag must be 0, 1, on, off or multi";

	const hppRequest_comment1_size = "Comment 1 must be less than 255 characters in length";
	const hppRequest_comment1_pattern = "Comment 1 must only contain the characters a-z A-Z 0-9 ' \", + \\u201C\\u201D ._ - & \\ / @ ! ? % ( ) * : � $ & \\u20AC # [ ] | =\" ; �����������������������������������������������������������������\\u0152\\u017D\\u0161\\u0153\\u017E\\u0178�";

	const hppRequest_comment2_size = "Comment 2 must be less than 255 characters in length";
	const hppRequest_comment2_pattern = "Comment 2 must only contain the characters a-z A-Z 0-9 ' \", + \\u201C\\u201D ._ - & \\ / @ ! ? % ( ) * : � $ & \\u20AC # [ ] | =\" ; �����������������������������������������������������������������\\u0152\\u017D\\u0161\\u0153\\u017E\\u0178�";

	const hppRequest_returnTss_size = "Return TSS flag must not be more than 1 character in length";
	const hppRequest_returnTss_pattern = "Return TSS must be 1 or 0";

	const hppRequest_shippingCode_size = "Shipping code must not be more than 30 characters in length";
	const hppRequest_shippingCode_pattern = "Shipping code must be of format <digits from postcode>|<digits from address> and contain only a-z A-Z 0-9 , . - / | spaces";

	const hppRequest_shippingCountry_size = "Shipping country must not contain more than 50 characters";
	const hppRequest_shippingCountry_pattern = "Shipping country must only contain the characters A-Z a-z 0-9 , . -";

	const hppRequest_billingCode_size = "Billing code must not be more than 60 characters in length";
	const hppRequest_billingCode_pattern = "Billing code must be of format <digits from postcode>|<digits from address> and contain only a-z A-Z 0-9 , . - / | spaces";

	const hppRequest_billingCountry_size = "Billing country must not contain more than 50 characters";
	const hppRequest_billingCountry_pattern = "Billing country must only contain the characters A-Z a-z 0-9 , . -";

	const hppRequest_customerNumber_size = "Customer number must not contain more than 50 characters";
	const hppRequest_customerNumber_pattern = "Customer number must only contain the characters a-z A-Z 0-9 - _ . , + @ spaces";

	const hppRequest_variableReference_size = "Variable reference must not contain more than 50 characters";
	const hppRequest_variableReference_pattern = "Variable reference must only contain the characters a-z A-Z 0-9 - _ . , + @ spaces";

	const hppRequest_productId_size = "Product ID must not contain more than 50 characters";
	const hppRequest_productId_pattern = "Product ID must only contain the characters a-z A-Z 0-9 - _ . , + @ spaces";

	const hppRequest_language_pattern = "Language must be 2 alphabetic characters only";

	const hppRequest_cardPaymentButtonText_size = "Card payment button text must not contain more than 25 characters";
	const hppRequest_cardPaymentButtonText_pattern = "Card payment button text must only contain the characters a-z A-Z 0-9 ' , + \\u201C \\u201D ._ - & \\ / @!? % ( ) * :� $ & \\u20AC # [] | =\"";

	const hppRequest_cardStorageEnable_size = "Card storage enable flag must not be more than 1 character in length";
	const hppRequest_cardStorageEnable_pattern = "Card storage enable flag must be 1 or 0";

	const hppRequest_offerSaveCard_size = "Offer to save card flag must not be more than 1 character in length";
	const hppRequest_offerSaveCard_pattern = "Offer to save card flag must be 1 or 0";

	const hppRequest_payerReference_size = "Payer reference must not be more than 50 characters in length";
	const hppRequest_payerReference_pattern = "Payer reference must only contain the characters a-z A-Z\\ 0-9 _ spaces";

	const hppRequest_paymentReference_size = "Payment reference must not be more than 50 characters in length";
	const hppRequest_paymentReference_pattern = "Payment reference must only contain  characters a-z A-Z 0-9 _ - spaces";

	const hppRequest_payerExists_size = "Payer exists flag must not be more than 1 character in length";
	const hppRequest_payerExists_pattern = "Payer exists flag must be 0, 1 or 2";

	const hppRequest_validateCardOnly_size = "Validate card only flag must not be more than 1 character in length";
	const hppRequest_validateCardOnly_pattern = "Validate card only flag must be 1 or 0";

	const hppRequest_dccEnable_size = "DCC enable flag must not be more than 1 character in length";
	const hppRequest_dccEnable_pattern = "DCC enable flag must be 1 or 0";

	const hppRequest_supplementary_data_pattern = "Supplementary data text must only contain the characters a-z A-Z 0-9 ' , + \\u201C \\u201D ._ - & \\ / @!? % ( ) * :� $ & \\u20AC # [] | =\"";
	const hppRequest_supplementary_data_size = "Supplementary data must not be more than 255 character in length";

}