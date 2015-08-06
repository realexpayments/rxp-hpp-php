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

		$hppRequest->setAccount( "azAZ09." );

		try {
			ValidationUtils::validate( $hppRequest );
		} catch ( RealexValidationException $e ) {
			$this->fail( "This HppRequest should have no validation errors." );
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

}
