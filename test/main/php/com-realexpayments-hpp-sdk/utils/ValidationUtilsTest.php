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
}
