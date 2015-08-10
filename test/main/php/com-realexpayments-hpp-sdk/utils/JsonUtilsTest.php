<?php


namespace com\realexpayments\hpp\sdk\utils;

use com\realexpayments\hpp\sdk\SampleJsonData;


/**
 * Test class for {@link JsonUtils}.
 *
 * @author vicpada
 *
 */
class JsonUtilsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test converting {@link HppRequest} to JSON.
     */
    public function testToJsonHppRequest()
    {

        $hppRequestExpected = SampleJsonData::generateValidHppRequest(false);
        $json = JsonUtils::toJson($hppRequestExpected);
        $hppRequestConverted = JsonUtils::fromJsonHppRequest($json);

        SampleJsonData::checkValidHppRequest($hppRequestExpected, $hppRequestConverted, true, $this);
        SampleJsonData::checkValidHppRequestSupplementaryData($hppRequestConverted, $this);

    }

    /**
     * Test converting JSON to {@link HppRequest}.
     *
     */
    public function testFromJsonHppRequest()
    {
        $path = SampleJsonData::VALID_HPP_REQUEST_JSON_PATH;
        $prefix = __DIR__ . '/../../../resources';
        $json = file_get_contents($prefix . $path);

        $hppRequestExpected = SampleJsonData::generateValidHppRequest(false);
        $hppRequestConverted = JsonUtils::fromJsonHppRequest($json);
        SampleJsonData::checkValidHppRequest($hppRequestExpected, $hppRequestConverted, true, $this);

    }

    public function testFromJsonHppRequestUnknownData()
    {
        $path = SampleJsonData::UNKNOWN_DATA_HPP_REQUEST_JSON_PATH;
        $prefix = __DIR__ . '/../../../resources';
        $json = file_get_contents($prefix . $path);

        $hppRequestExpected = SampleJsonData::generateValidHppRequest(false);
        $hppRequestConverted = JsonUtils::fromJsonHppRequest($json);
        SampleJsonData::checkValidHppRequest($hppRequestExpected, $hppRequestConverted, true, $this);
        SampleJsonData::checkValidHppRequestSupplementaryData($hppRequestConverted, $this);
    }

    public function testToJsonHppResponse()
    {

        $hppResponseExpected = SampleJsonData::generateValidHppResponse();
        $json = JsonUtils::toJson($hppResponseExpected);
        $hppResponseConverted = JsonUtils::fromJsonHppResponse($json);
        SampleJsonData::checkValidHppResponse($hppResponseExpected,$hppResponseConverted, $this);
    }
}
