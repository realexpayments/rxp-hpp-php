<?php


namespace com\realexpayments\hpp\sdk\utils;

use com\realexpayments\hpp\sdk\RealexValidationException;
use com\realexpayments\hpp\sdk\SampleJsonData;
use com\realexpayments\hpp\sdk\validators\ValidationMessages;


/**
 * Test class for validating {@link HppRequest}.
 *
 * @author vicpada
 */
class ValidationUtilsTest extends \PHPUnit_Framework_TestCase {


	/**
	 * Test validation passed
	 */
	public function testValidationPassed() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should have no validation errors." );
		}

	}

	/**
	 * Test merchant ID.
	 */
	public function testMerchantId() {

		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setMerchantId( "" );


		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_merchantId_size, $validationMessages[0] );
		}

		$charsAtMax = str_repeat( "1", 50 );
		$hppRequest->setMerchantId( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "1", 51 );
		$hppRequest->setMerchantId( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_merchantId_size, $validationMessages[0] );
		}

		$hppRequest->setMerchantId( "azAZ09." );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should have no validation errors." );
		}

		$hppRequest->setMerchantId( "$&^*" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_merchantId_pattern, $validationMessages[0] );
		}
	}

	/**
	 * Test Account
	 */
	public function testAccount() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setAccount( "" );


		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}

		$hppRequest->setAccount( "azAZ09" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}

		$charsAtMax = str_repeat( "1", 30 );
		$hppRequest->setAccount( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "1", 31 );
		$hppRequest->setAccount( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_account_size, $validationMessages[0] );
		}

		$hppRequest->setAccount( "$&^*" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_account_pattern, $validationMessages[0] );
		}
	}

	/**
	 * Test Order Id
	 */
	public function testOrderId() {

		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setOrderId( "" );


		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}

		$hppRequest->setOrderId( "azAZ09_-" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}

		$charsAtMax = str_repeat( "1", 50 );
		$hppRequest->setOrderId( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "1", 51 );
		$hppRequest->setOrderId( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_orderId_size, $validationMessages[0] );
		}


		$hppRequest->setOrderId( "$&^*" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_orderId_pattern, $validationMessages[0] );
		}
	}

	/**
	 * Test amount
	 */
	public function testAmount() {

		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setAmount( "" );


		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_amount_size, $validationMessages[0] );
		}

		$charsAtMax = str_repeat( "1", 11 );
		$hppRequest->setAmount( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "1", 12 );
		$hppRequest->setAmount( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_amount_size, $validationMessages[0] );
		}

		$hppRequest->setAmount( "abc" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_amount_pattern, $validationMessages[0] );
		}

		$hppRequest->setAmount( "$&^*" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_amount_pattern, $validationMessages[0] );
		}

		// TODO: RealVault iteration cases
	}

	/**
	 * Currency test
	 */
	public function testCurrency() {

		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setCurrency( "" );


		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_currency_size, $validationMessages[0] );
		}


		$hppRequest->setCurrency( "EuR" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$hppRequest->setCurrency( "abcd" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_currency_size, $validationMessages[0] );
		}

		$hppRequest->setCurrency( "ab1" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_currency_pattern, $validationMessages[0] );
		}
	}


	/**
	 * Test time stamp
	 */
	public function testTimeStamp() {

		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setTimeStamp( "" );


		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_timestamp_size, $validationMessages[0] );
		}


		$charsAtMax = str_repeat( "1", 14 );
		$hppRequest->setTimeStamp( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "1", 15 );
		$hppRequest->setTimeStamp( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_timestamp_size, $validationMessages[0] );
		}

		$hppRequest->setTimeStamp( "1234567890123a" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_timestamp_pattern, $validationMessages[0] );
		}

	}


	/**
	 * Test hash
	 */
	public function testHash() {

		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setHash( "" );


		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_hash_size, $validationMessages[0] );
		}


		$charsAtMax = str_repeat( "a", 40 );
		$hppRequest->setHash( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "a", 41 );
		$hppRequest->setHash( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_hash_size, $validationMessages[0] );
		}

		$hppRequest->setHash( "5d8f05abd618e50db4861a61cc940112786474c_" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_hash_pattern, $validationMessages[0] );
		}
	}

	/**
	 * Test auto settle flag
	 */
	public function testAutoSettleFlag() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setAutoSettleFlag( null );


		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}

		$hppRequest->setAutoSettleFlag( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setAutoSettleFlag( "0" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$hppRequest->setAutoSettleFlag( "1" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$hppRequest->setAutoSettleFlag( "on" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$hppRequest->setAutoSettleFlag( "off" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$hppRequest->setAutoSettleFlag( "multi" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$hppRequest->setAutoSettleFlag( "ON" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$hppRequest->setAutoSettleFlag( "OFF" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$hppRequest->setAutoSettleFlag( "MULTI" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$hppRequest->setAutoSettleFlag( "MuLtI" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$hppRequest->setAutoSettleFlag( "a" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_autoSettleFlag_pattern, $validationMessages[0] );
		}
	}

	/**
	 * Test comment one
	 */
	public function testCommentOne() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setCommentOne( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setCommentOne( "a-z A-Z 0-9 ' \", + “” ._ - & \\ / @ ! ? % ( )* : £ $ & € # [ ] | = ;ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõö÷ø¤ùúûüýþÿŒŽšœžŸ¥" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$charsAtMax = str_repeat( "1", 255 );
		$hppRequest->setCommentOne( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "1", 256 );
		$hppRequest->setCommentOne( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_comment1_size, $validationMessages[0] );
		}
	}

	/**
	 * Test comment two
	 */
	public function testCommentTwo() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setCommentTwo( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setCommentTwo( "a-z A-Z 0-9 ' \", + “” ._ - & \\ / @ ! ? % ( )* : £ $ & € # [ ] | = ;ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõö÷ø¤ùúûüýþÿŒŽšœžŸ¥" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$charsAtMax = str_repeat( "1", 255 );
		$hppRequest->setCommentTwo( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "1", 256 );
		$hppRequest->setCommentTwo( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_comment2_size, $validationMessages[0] );
		}
	}

	/**
	 * Test TSS Flag
	 */
	public function testReturnTssFlag() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setReturnTss( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$hppRequest->setReturnTss( null );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$hppRequest->setReturnTss( "11" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_returnTss_size, $validationMessages[0] );
		}

		$hppRequest->setReturnTss( "a" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_returnTss_pattern, $validationMessages[0] );
		}
	}



	/**
	 * Test shipping code
	 */
	public function testShippingCode() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setShippingCode( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setShippingCode( "azAZ09,.-/|" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$charsAtMax = str_repeat( "1", 30 );
		$hppRequest->setShippingCode( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "1", 31 );
		$hppRequest->setShippingCode( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_shippingCode_size, $validationMessages[0] );
		}


		$hppRequest->setShippingCode( "+" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_shippingCode_pattern, $validationMessages[0] );
		}
	}

	/**
	 * Test shipping country
	 */
	public function testShippingCountry() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setShippingCountry( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setShippingCountry( "AZaz09,.-" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$charsAtMax = str_repeat( "1", 50 );
		$hppRequest->setShippingCountry( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "1", 51 );
		$hppRequest->setShippingCountry( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_shippingCountry_size, $validationMessages[0] );
		}


		$hppRequest->setShippingCountry( "+" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_shippingCountry_pattern, $validationMessages[0] );
		}
	}


	/**
	 * Test billing code
	 */
	public function testBillingCode() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setBillingCode( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setBillingCode( "azAZ09,.-/|" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$charsAtMax = str_repeat( "1", 60 );
		$hppRequest->setBillingCode( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "1", 61 );
		$hppRequest->setBillingCode( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_billingCode_size, $validationMessages[0] );
		}


		$hppRequest->setBillingCode( "+" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_billingCode_pattern, $validationMessages[0] );
		}
	}

	/**
	 * Test billing country
	 */
	public function testBillingCountry() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setBillingCountry( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setBillingCountry( "AZaz09,.-" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$charsAtMax = str_repeat( "1", 50 );
		$hppRequest->setBillingCountry( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "1", 51 );
		$hppRequest->setBillingCountry( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_billingCountry_size, $validationMessages[0] );
		}


		$hppRequest->setBillingCountry( "+" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_billingCountry_pattern, $validationMessages[0] );
		}
	}


	/**
	 * Test customer number
	 */
	public function testCustomerNumber() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setCustomerNumber( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setCustomerNumber( "az AZ 09 - _ . ,+ @ " );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$charsAtMax = str_repeat( "1", 50 );
		$hppRequest->setCustomerNumber( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "1", 51 );
		$hppRequest->setCustomerNumber( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_customerNumber_size, $validationMessages[0] );
		}


		$hppRequest->setCustomerNumber( "&" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_customerNumber_pattern, $validationMessages[0] );
		}
	}

	/**
	 * Test variable reference
	 */
	public function testVariableReference() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setVariableReference( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setVariableReference( "az AZ 09 - _ . ,+ @ " );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$charsAtMax = str_repeat( "a", 50 );
		$hppRequest->setVariableReference( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "a", 51 );
		$hppRequest->setVariableReference( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_variableReference_size, $validationMessages[0] );
		}


		$hppRequest->setVariableReference( "&" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_variableReference_pattern, $validationMessages[0] );
		}
	}


	/**
	 * Test product id
	 */
	public function testProductId() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setProductId( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setProductId( "az AZ 09 - _ . ,+ @ " );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$charsAtMax = str_repeat( "a", 50 );
		$hppRequest->setProductId( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "a", 51 );
		$hppRequest->setProductId( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_productId_size, $validationMessages[0] );
		}


		$hppRequest->setProductId( "&" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_productId_pattern, $validationMessages[0] );
		}
	}

	/**
	 * Test language
	 */
	public function testLanguage() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setLanguage( null );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setLanguage( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}



		$hppRequest->setLanguage( "a" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_language_pattern, $validationMessages[0] );
		}


		$hppRequest->setLanguage( "abc" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_language_pattern, $validationMessages[0] );
		}


		$hppRequest->setLanguage( "%&" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_language_pattern, $validationMessages[0] );
		}
	}



	/**
	 * Test card payment button
	 */
	public function testCardPaymentButton() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setCardPaymentButtonText( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setCardPaymentButtonText( " azAZ09'\",+“”._- & " );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$hppRequest->setCardPaymentButtonText( "\\/@!?%()*:£$&€#[]|" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$hppRequest->setCardPaymentButtonText( "=ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒ" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$hppRequest->setCardPaymentButtonText( "ÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæ" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}



		$hppRequest->setCardPaymentButtonText( "çèéêëìíîïðñòóôõö÷ø¤ù" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$hppRequest->setCardPaymentButtonText( "úûüýþÿŒŽšœžŸ¥" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$charsAtMax = str_repeat( "1", 25 );
		$hppRequest->setCardPaymentButtonText( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "a", 26 );
		$hppRequest->setCardPaymentButtonText( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_cardPaymentButtonText_size, $validationMessages[0] );
		}

	}

	/**
	 * Test validate card only
	 */
	public function testValidateCardOnly() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setValidateCardOnly( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setValidateCardOnly( "0" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}



		$hppRequest->setValidateCardOnly( "11" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_validateCardOnly_size, $validationMessages[0] );
		}


		$hppRequest->setValidateCardOnly( "a" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_validateCardOnly_pattern, $validationMessages[0] );
		}


		$hppRequest->setValidateCardOnly( "1" );
		$hppRequest->setAmount( "0" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}
	}

	/**
	 * Test dcc enable
	 */
	public function testDccEnable() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setDccEnable( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setDccEnable( "0" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}



		$hppRequest->setDccEnable( "11" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_dccEnable_size, $validationMessages[0] );
		}


		$hppRequest->setDccEnable( "a" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_dccEnable_pattern, $validationMessages[0] );
		}


	}


}
