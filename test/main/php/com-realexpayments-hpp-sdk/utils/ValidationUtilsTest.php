<?php


namespace com\realexpayments\hpp\sdk\utils;
use com\realexpayments\hpp\sdk\RealexValidationException;
use com\realexpayments\hpp\sdk\SampleJsonData;


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

}
