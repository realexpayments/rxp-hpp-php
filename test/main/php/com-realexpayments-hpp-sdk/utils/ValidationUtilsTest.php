<?php


namespace com\realexpayments\hpp\sdk\utils;

use com\realexpayments\hpp\sdk\domain\Flag;
use com\realexpayments\hpp\sdk\RealexValidationException;
use com\realexpayments\hpp\sdk\SampleJsonData;
use com\realexpayments\hpp\sdk\validators\ValidationMessages;


/**
 * Test class for validating {@link HppRequest}.
 *
 * @author vicpada
 */
class ValidationUtilsTest extends \PHPUnit\Framework\TestCase {


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

		$hppRequest->setValidateCardOnly( Flag::TRUE );
		$hppRequest->setAmount( "0" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$hppRequest->setValidateCardOnly( Flag::TRUE );
		$hppRequest->setAmount( "1" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_amount_otb, $validationMessages[0] );
		}
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

	/**
	 * Test card storage enable.
	 */
	public function testCardStorageEnable() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setCardStorageEnable( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}

		$hppRequest->setCardStorageEnable( "11" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_cardStorageEnable_size, $validationMessages[0] );
		}


		$hppRequest->setCardStorageEnable( "a" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_cardStorageEnable_pattern, $validationMessages[0] );
		}
	}

	/**
	 * Test offer save card.
	 */
	public function testOfferSaveCard() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setOfferSaveCard( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}

		$hppRequest->setOfferSaveCard( "1" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}

		$hppRequest->setOfferSaveCard( "0" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}

		$hppRequest->setOfferSaveCard( "11" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_offerSaveCard_size, $validationMessages[0] );
		}


		$hppRequest->setOfferSaveCard( "a" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_offerSaveCard_pattern, $validationMessages[0] );
		}
	}


	/**
	 * Test payer reference
	 */
	public function testPayerReference() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setPayerReference( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setPayerReference( "azAZ09\\ _" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$charsAtMax = str_repeat( "a", 50 );
		$hppRequest->setPayerReference( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "a", 51 );
		$hppRequest->setPayerReference( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_payerReference_size, $validationMessages[0] );
		}


		$hppRequest->setPayerReference( "+" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_payerReference_pattern, $validationMessages[0] );
		}
	}


	/**
	 * Test payment reference
	 */
	public function testPaymentReference() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setPaymentReference( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}


		$hppRequest->setPaymentReference( "azAZ09-_" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$charsAtMax = str_repeat( "1", 50 );
		$hppRequest->setPaymentReference( $charsAtMax );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax = str_repeat( "a", 51 );
		$hppRequest->setPaymentReference( $charsOverMax );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_paymentReference_size, $validationMessages[0] );
		}


		$hppRequest->setPaymentReference( "+" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_paymentReference_pattern, $validationMessages[0] );
		}
	}

	/**
	 * Test payer exists
	 */
	public function testPayerExists() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setPayerExists( "" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}

		$hppRequest->setPayerExists( "1" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}

		$hppRequest->setPayerExists( "0" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}

		$hppRequest->setPayerExists( "2" );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}

		$hppRequest->setPayerExists( "11" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_payerExists_size, $validationMessages[0] );
		}


		$hppRequest->setPayerExists( "a" );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_payerExists_pattern, $validationMessages[0] );
		}
	}


	/**
	 * Test supplementary data first field
	 */
	public function testCardSupplementaryData1() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$supplementaryData1  = "";
		$supplementaryData   = array();
		$supplementaryData[] = $supplementaryData1;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}

		$supplementaryData1  = " azAZ09'\",+“”._- & ";
		$supplementaryData   = array();
		$supplementaryData[] = $supplementaryData1;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$supplementaryData1  = "\\/@!?%()*:£$&€#[]|";
		$supplementaryData   = array();
		$supplementaryData[] = $supplementaryData1;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$supplementaryData1  = "=ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒ";
		$supplementaryData   = array();
		$supplementaryData[] = $supplementaryData1;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$supplementaryData1  = "ÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæ";
		$supplementaryData   = array();
		$supplementaryData[] = $supplementaryData1;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$supplementaryData1  = "çèéêëìíîïðñòóôõö÷ø¤ù";
		$supplementaryData   = array();
		$supplementaryData[] = $supplementaryData1;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$supplementaryData1  = "úûüýþÿŒŽšœžŸ¥";
		$supplementaryData   = array();
		$supplementaryData[] = $supplementaryData1;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$charsAtMax          = str_repeat( "1", 255 );
		$supplementaryData   = array();
		$supplementaryData[] = $charsAtMax;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$charsOverMax        = str_repeat( "a", 256 );
		$supplementaryData   = array();
		$supplementaryData[] = $charsOverMax;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_supplementary_data_size, $validationMessages[0] );
		}

	}

	/**
	 * Test supplementary data second field
	 */
	public function testCardSupplementaryData2() {
		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$supplementaryData1 = "";
		$supplementaryData2 = "";
		$supplementaryData  = array();

		$supplementaryData[] = $supplementaryData1;
		$supplementaryData[] = $supplementaryData2;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {

			$this->fail( "This HppRequest should have no validation errors." );
		}

		$supplementaryData1 = "";
		$supplementaryData2  = " azAZ09'\",+“”._- & ";
		$supplementaryData   = array();

		$supplementaryData[] = $supplementaryData1;
		$supplementaryData[] = $supplementaryData2;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$supplementaryData1 = "";
		$supplementaryData2  = "\\/@!?%()*:£$&€#[]|";
		$supplementaryData   = array();

		$supplementaryData[] = $supplementaryData1;
		$supplementaryData[] = $supplementaryData2;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$supplementaryData1 = "";
		$supplementaryData2  = "=ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒ";
		$supplementaryData   = array();

		$supplementaryData[] = $supplementaryData1;
		$supplementaryData[] = $supplementaryData2;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$supplementaryData1 = "";
		$supplementaryData2  = "ÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæ";
		$supplementaryData   = array();

		$supplementaryData[] = $supplementaryData1;
		$supplementaryData[] = $supplementaryData2;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$supplementaryData1 = "";
		$supplementaryData2  = "çèéêëìíîïðñòóôõö÷ø¤ù";
		$supplementaryData   = array();

		$supplementaryData[] = $supplementaryData1;
		$supplementaryData[] = $supplementaryData2;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$supplementaryData1 = "";
		$supplementaryData2  = "úûüýþÿŒŽšœžŸ¥";
		$supplementaryData   = array();

		$supplementaryData[] = $supplementaryData1;
		$supplementaryData[] = $supplementaryData2;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$supplementaryData1 = "";
		$charsAtMax          = str_repeat( "1", 255 );
		$supplementaryData   = array();

		$supplementaryData[] = $supplementaryData1;
		$supplementaryData[] = $charsAtMax;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$supplementaryData1 = "";
		$charsOverMax        = str_repeat( "a", 256 );
		$supplementaryData   = array();

		$supplementaryData[] = $supplementaryData1;
		$supplementaryData[] = $charsOverMax;

		$hppRequest->setSupplementaryData( $supplementaryData );

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_supplementary_data_size, $validationMessages[0] );
		}

	}


	/**
	 * Test HPP Version
	 */
	public function testHppVersion() {

		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setHppVersion(1);

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$hppRequest->setHppVersion("2");

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$hppRequest->setHppVersion(0);

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_hppVersion_pattern, $validationMessages[0] );
		}

		$hppRequest->setHppVersion(12);

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_hppVersion_size, $validationMessages[0] );
		}

		$hppRequest->setHppVersion('a');

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_hppVersion_pattern, $validationMessages[0] );
		}

		$hppRequest->setHppVersion('1 a');

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_hppVersion_size, $validationMessages[0] );
		}
	}

	/**
	 * Test HPP Version
	 */
	public function testHppSelectStoredCard() {

		$hppRequest = SampleJsonData::generateValidHppRequest( false );
		$hppRequest->generateDefaults( SampleJsonData::SECRET );

		$hppRequest->setHppSelectStoredCard("payerref123");

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$hppRequest->setHppSelectStoredCard(str_repeat('a',50));

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}


		$hppRequest->setHppSelectStoredCard(str_repeat('a',51));

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_hppSelectStoredCard_size, $validationMessages[0] );
		}

		$hppRequest->setHppSelectStoredCard("!!!");

		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_hppSelectStoredCard_pattern, $validationMessages[0] );
		}

	}
	/**
	 * Test converting {@link HppRequest} to JSON.
	 * Testing import from json, validate errors
	 */
	public function testToJsonHppRequestWithHppVersionFail() {

		$path   = SampleJsonData::INVALID_HPP_REQUEST_HPP_VERSION_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );


		$hppRequestConverted = JsonUtils::fromJsonHppRequest( $json );

		try {
			ValidationUtils::validate( $hppRequestConverted );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_hppVersion_pattern, $validationMessages[0] );
			$this->assertEquals( ValidationMessages::hppRequest_hppSelectStoredCard_size, $validationMessages[1] );
		}
	}

	/**
	 * Test converting {@link HppRequest} to JSON.
	 * Testing import from json, NO Hpp_version => so you are not allow to put the hpp select stored card
	 */
	public function testToJsonHppRequestWithHppVersion2() {

		$path   = SampleJsonData::VALID_HPP_REQUEST_HPP_VERSION_JSON_PATH2;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );


		$hppRequestConverted = JsonUtils::fromJsonHppRequest( $json );

		try {
			ValidationUtils::validate( $hppRequestConverted );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should not have validation errors." );
		}

		$this->assertEmpty( $hppRequestConverted->getHppVersion());
		$this->assertNotEmpty( $hppRequestConverted->getHppSelectStoredCard());
	}

	/**
	 * Test converting {@link HppRequest} to JSON.
	 * Testing import from json
	 */
	public function testToJsonPostDimensions2() {

		$path   = SampleJsonData::VALID_HPP_REQUEST_HPP_POST_DIMENSIONS_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );

		$hppRequestConverted = JsonUtils::fromJsonHppRequest( $json );

		SampleJsonData::checkValidHppRequestPostDimensions($hppRequestConverted,$this);

	}
	
	/**
	 * Test validation post dimensions pass
	 */
	public function testValidationPassedPostDimensions() {
		$path   = SampleJsonData::VALID_HPP_REQUEST_HPP_POST_DIMENSIONS_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );

		$hppRequestConverted = JsonUtils::fromJsonHppRequest( $json );
		$hppRequestConverted->generateDefaults( SampleJsonData::SECRET );

		try {
			ValidationUtils::validate( $hppRequestConverted );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should have no validation errors." );
		}
	}

	/**
	 * Test converting a {@link HppRequest} object to JSON. Includes validation and generation of defaults.
	 */
	public function testValidationFailsPostDimensions()
	{
		$hppRequest = SampleJsonData::generateValidHppRequestWithEmptyDefaults(false);
		//limit is 255
		$postDimensions = str_repeat('a',256);
		//testing add method
		$hppRequest = $hppRequest->addPostDimensions($postDimensions);


		try {
			ValidationUtils::validate( $hppRequest );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_postDimensions_size, $validationMessages[0] );
		}
	}

	/**
	 * Test validation post dimensions pass
	 */
	public function testValidationPassedPostResponse() {
		$path   = SampleJsonData::VALID_HPP_REQUEST_HPP_POST_RESPONSE_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );

		$hppRequestConverted = JsonUtils::fromJsonHppRequest( $json );
		$hppRequestConverted->generateDefaults( SampleJsonData::SECRET );

		try {
			ValidationUtils::validate( $hppRequestConverted );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should have no validation errors." );
		}
	}

	/**
	 * Test validation post dimensions fails
	 */
	public function testValidationPassedPostResponseFails() {
		$path   = SampleJsonData::INVALID_HPP_REQUEST_HPP_POST_RESPONSE_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );

		$hppRequestConverted = JsonUtils::fromJsonHppRequest( $json );
		$hppRequestConverted->generateDefaults( SampleJsonData::SECRET );

		try {
			ValidationUtils::validate( $hppRequestConverted );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_postResponse_size, $validationMessages[0] );
		}
	}

	/**
	 * Test validation post dimensions fails
	 */
	public function testValidationPassedFails() {
		$path   = SampleJsonData::INVALID_HPP_REQUEST_HPP_POST_BOTH_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );

		$hppRequestConverted = JsonUtils::fromJsonHppRequest( $json );
		$hppRequestConverted->generateDefaults( SampleJsonData::SECRET );

		try {
			ValidationUtils::validate( $hppRequestConverted );
			$this->fail( "This HppRequest should have validation errors." );
		} catch ( RealexValidationException $e ) {
			$validationMessages = $e->getValidationMessages();
			$this->assertEquals( ValidationMessages::hppRequest_postDimensions_size, $validationMessages[0] );
			$this->assertEquals( ValidationMessages::hppRequest_postResponse_size, $validationMessages[1] );
		}
	}


	/**
	 * Test validation post dimensions fails
	 */
	public function testValidationPassedSuccess() {
		$path   = SampleJsonData::VALID_HPP_REQUEST_HPP_POST_BOTH_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );

		$hppRequestConverted = JsonUtils::fromJsonHppRequest( $json );
		$hppRequestConverted->generateDefaults( SampleJsonData::SECRET );

		try {
			ValidationUtils::validate( $hppRequestConverted );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest shouldn't have validation errors." );
		}

	}
}
