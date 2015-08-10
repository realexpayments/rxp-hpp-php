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

    /**
     *
     */
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

    /**
     * Test converting {@link HppResponse} to JSON.
     */
    public function testToJsonHppResponse()
    {

        $hppResponseExpected = SampleJsonData::generateValidHppResponse();
        $json = JsonUtils::toJson($hppResponseExpected);
        $hppResponseConverted = JsonUtils::fromJsonHppResponse($json);
        SampleJsonData::checkValidHppResponse($hppResponseExpected, $hppResponseConverted, $this);
    }

    /**
     * Test converting JSON to {@link HppResponse}.
     */
    public function  testFromJsonHppResponse()
    {
        $path = SampleJsonData::VALID_HPP_RESPONSE_JSON_PATH;
        $prefix = __DIR__ . '/../../../resources';
        $json = file_get_contents($prefix . $path);

        $hppResponseExpected = SampleJsonData::generateValidHppResponse();
        $hppResponseConverted = JsonUtils::fromJsonHppResponse($json);
        SampleJsonData::checkValidHppResponse($hppResponseExpected, $hppResponseConverted, $this);
    }


    /**
     * Test converting JSON with unknown data to {@link HppResponse}.
     */
    public function  testFromJsonHppResponseUnknownData()
    {
        $path = SampleJsonData::UNKNOWN_DATA_HPP_RESPONSE_JSON_PATH;
        $prefix = __DIR__ . '/../../../resources';
        $json = file_get_contents($prefix . $path);

        $hppResponseExpected = SampleJsonData::generateValidHppResponse();
        $hppResponseConverted = JsonUtils::fromJsonHppResponse($json);
        SampleJsonData::checkValidHppResponse($hppResponseExpected, $hppResponseConverted, $this);
        SampleJsonData::checkValidHppResponseSupplementaryData($hppResponseConverted, $this);
    }
}
