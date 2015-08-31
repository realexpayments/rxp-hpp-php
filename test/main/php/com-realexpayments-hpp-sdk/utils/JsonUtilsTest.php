<?php


namespace com\realexpayments\hpp\sdk\utils;

use com\realexpayments\hpp\sdk\RealexHpp;
use com\realexpayments\hpp\sdk\SampleJsonData;


/**
 * Test class for {@link JsonUtils}.
 *
 * @author vicpada
 *
 */
class JsonUtilsTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Test converting {@link HppRequest} to JSON.
	 */
	public function testToJsonHppRequest() {

		$hppRequestExpected  = SampleJsonData::generateValidHppRequest( false );
		$json                = JsonUtils::toJson( $hppRequestExpected );
		$hppRequestConverted = JsonUtils::fromJsonHppRequest( $json );

		SampleJsonData::checkValidHppRequest( $hppRequestExpected, $hppRequestConverted, true, $this );
		SampleJsonData::checkValidHppRequestSupplementaryData( $hppRequestConverted, $this );

	}

	/**
	 * Test converting JSON to {@link HppRequest}.
	 *
	 */
	public function testFromJsonHppRequest() {
		$path   = SampleJsonData::VALID_HPP_REQUEST_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );

		$hppRequestExpected  = SampleJsonData::generateValidHppRequest( false );
		$hppRequestConverted = JsonUtils::fromJsonHppRequest( $json );
		SampleJsonData::checkValidHppRequest( $hppRequestExpected, $hppRequestConverted, true, $this );

	}

	/**
	 *
	 */
	public function testFromJsonHppRequestUnknownData() {
		$path   = SampleJsonData::UNKNOWN_DATA_HPP_REQUEST_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );

		$hppRequestExpected  = SampleJsonData::generateValidHppRequest( false );
		$hppRequestConverted = JsonUtils::fromJsonHppRequest( $json );
		SampleJsonData::checkValidHppRequest( $hppRequestExpected, $hppRequestConverted, true, $this );
		SampleJsonData::checkValidHppRequestSupplementaryData( $hppRequestConverted, $this );
	}

	/**
	 * Test converting {@link HppResponse} to JSON.
	 */
	public function testToJsonHppResponse() {

		$hppResponseExpected  = SampleJsonData::generateValidHppResponse();
		$json                 = JsonUtils::toJson( $hppResponseExpected );
		$hppResponseConverted = JsonUtils::fromJsonHppResponse( $json );
		SampleJsonData::checkValidHppResponse( $hppResponseExpected, $hppResponseConverted, $this );
	}

	/**
	 * Test converting JSON to {@link HppResponse}.
	 */
	public function  testFromJsonHppResponse() {
		$path   = SampleJsonData::VALID_HPP_RESPONSE_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );

		$hppResponseExpected  = SampleJsonData::generateValidHppResponse();
		$hppResponseConverted = JsonUtils::fromJsonHppResponse( $json );
		SampleJsonData::checkValidHppResponse( $hppResponseExpected, $hppResponseConverted, $this );
	}


	/**
	 * Test converting JSON with unknown data to {@link HppResponse}.
	 */
	public function  testFromJsonHppResponseUnknownData() {
		$path   = SampleJsonData::UNKNOWN_DATA_HPP_RESPONSE_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );

		$hppResponseExpected  = SampleJsonData::generateValidHppResponse();
		$hppResponseConverted = JsonUtils::fromJsonHppResponse( $json );
		SampleJsonData::checkValidHppResponse( $hppResponseExpected, $hppResponseConverted, $this );
		SampleJsonData::checkValidHppResponseSupplementaryData( $hppResponseConverted, $this );
	}


	/**
	 * Test converting JSON with empty ECI to {@link HppResponse}.
	 */
	public function  testFromJsonHppResponseEmptyECI() {
		$path   = SampleJsonData::VALID_HPP_RESPONSE_EMPTY_ECI_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );


		$hppResponseConverted = JsonUtils::fromJsonHppResponse( $json );

		$this->assertEquals( "", $hppResponseConverted->getEci() );
	}

	/**
	 * Test converting JSON with empty ECI to {@link HppResponse}.
	 */
	public function  testFromJsonHppResponseNoECIField() {
		$path   = SampleJsonData::VALID_HPP_RESPONSE_NO_ECI_FIELD_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );


		$hppResponseConverted = JsonUtils::fromJsonHppResponse( $json );

		$this->assertEquals( "", $hppResponseConverted->getEci() );
	}

	/**
	 * Test converting JSON with empty ECI to {@link HppResponse}.
	 */
	public function  testFromJsonHppResponseNoECIFieldEncoded() {
		$path   = SampleJsonData::VALID_HPP_RESPONSE_NO_ECI_FIELD_ENCODED_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );


		$hppResponseConverted = JsonUtils::fromJsonHppResponse( $json );
		$hppResponseConverted = $hppResponseConverted->decode(RealexHpp::ENCODING_CHARSET);

		$this->assertEquals( "", $hppResponseConverted->getEci() );
	}

	/**
	 * Test converting JSON with no TSS Information to {@link HppResponse}.
	 */
	public function  testFromJsonHppResponseNoTSS() {
		$path   = SampleJsonData::VALID_HPP_RESPONSE_NO_TSS_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );


		$hppResponseConverted = JsonUtils::fromJsonHppResponse( $json );

		$this->assertEquals( "", $hppResponseConverted->getTss() );
	}

	/**
	 * Test converting JSON with no TSS Information to {@link HppResponse}.
	 */
	public function  testFromJsonHppResponseNoTSSEncoded() {
		$path   = SampleJsonData::VALID_HPP_RESPONSE_NO_TSS_JSON_PATH;
		$prefix = __DIR__ . '/../../../resources';
		$json   = file_get_contents( $prefix . $path );


		$hppResponseConverted = JsonUtils::fromJsonHppResponse( $json );
		$hppResponseConverted = $hppResponseConverted->decode(RealexHpp::ENCODING_CHARSET);

		$this->assertEquals( "", $hppResponseConverted->getTss() );
	}
}
