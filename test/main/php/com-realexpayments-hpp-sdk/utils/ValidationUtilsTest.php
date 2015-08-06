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

		$charsAtMax = str_repeat( "1",11 );
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

}
