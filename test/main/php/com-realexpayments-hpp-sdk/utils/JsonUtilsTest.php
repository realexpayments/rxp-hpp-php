<?php


namespace com\realexpayments\hpp\sdk\utils;
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

		$hppRequestExpected = SampleJsonData::generateValidHppRequest(false);
		$json = JsonUtils::toJson($hppRequestExpected);
		$hppRequestConverted = JsonUtils::fromJsonHppRequest($json);

		SampleJsonData::checkValidHppRequest($hppRequestExpected, $hppRequestConverted, true,$this);
		SampleJsonData::checkValidHppRequestSupplementaryData($hppRequestConverted,$this);

	}
}
