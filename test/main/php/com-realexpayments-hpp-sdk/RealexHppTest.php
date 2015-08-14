<?php

namespace com\realexpayments\hpp\sdk;


/**
 * Unit test class for {@link RealexHpp}
 *
 * @author vicpada
 *
 */
class RealexHppTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var RealexHpp
     */
    private static $realex_HPP;

    public static function setUpBeforeClass()
    {
        self::$realex_HPP = new RealexHpp(SampleJsonData::SECRET);
    }

    /**
     * Test converting a {@link HppRequest} object to JSON. Includes validation and generation of defaults.
     */
    public function testRequestToJsonSuccess()
    {
        $hppRequestExpected = SampleJsonData::generateValidHppRequestWithEmptyDefaults(false);
        $json = self::$realex_HPP->requestToJson($hppRequestExpected);

        $realexHPP = self::$realex_HPP;

        $hppRequestConverted = self::$realex_HPP->requestFromJson($json);
        $hppRequestExpected->decode($realexHPP::ENCODING_CHARSET);
        SampleJsonData::checkValidHppRequest($hppRequestExpected, $hppRequestConverted, false, $this);
        SampleJsonData::checkValidHppRequestSupplementaryData($hppRequestConverted, $this);
    }

    /**
     * Test converting encoded JSON to {@link HppRequest}.
     */
    public function testRequestFromJsonEncodedSuccess()
    {
        $hppRequestExpected = SampleJsonData::generateValidHppRequest(false);

        $path = SampleJsonData::VALID_HPP_REQUEST_ENCODED_JSON_PATH;
        $prefix = __DIR__ . '/../../resources';
        $json = file_get_contents($prefix . $path);

        $realexHPP = self::$realex_HPP;
        $hppRequestConverted = $realexHPP->requestFromJson($json);
        SampleJsonData::checkValidHppRequest($hppRequestExpected, $hppRequestConverted, false, $this);
    }

    /**
     * Test converting unencoded JON to {@link HppRequest}.
     */
    public function testRequestFromJsonDecodedSuccess()
    {
        $hppRequestExpected = SampleJsonData::generateValidHppRequest(false);

        $path = SampleJsonData::VALID_HPP_REQUEST_JSON_PATH;
        $prefix = __DIR__ . '/../../resources';
        $json = file_get_contents($prefix . $path);

        $realexHPP = self::$realex_HPP;
        $hppRequestConverted = $realexHPP->requestFromJson($json, false);
        SampleJsonData::checkValidHppRequest($hppRequestExpected, $hppRequestConverted, false, $this);
    }


    public function testRequestFromJsonCardStorageSuccess()
    {
        $hppRequestExpected = SampleJsonData::generateValidHppRequest(true);

        $path = SampleJsonData::VALID_HPP_REQUEST_CARD_STORAGE_JSON_PATH;
        $prefix = __DIR__ . '/../../resources';
        $json = file_get_contents($prefix . $path);

        $realexHPP = self::$realex_HPP;
        $hppRequestConverted = $realexHPP->requestFromJson($json, false);
        SampleJsonData::checkValidHppRequest($hppRequestExpected, $hppRequestConverted, false, $this);
    }

    /**
     * Test converting {@link HppResponse} to JSON.  Includes hash validation.
     */
    public function testResponseToJsonSuccess()
    {
        $hppResponseExpected = SampleJsonData::generateValidHppResponse();
        $json = self::$realex_HPP->responseToJson($hppResponseExpected);

        $realexHPP = self::$realex_HPP;

        $hppResponseConverted = self::$realex_HPP->responseFromJson($json);
        $hppResponseExpected->decode($realexHPP::ENCODING_CHARSET);

        SampleJsonData::checkValidHppResponse($hppResponseExpected, $hppResponseConverted, $this);
        SampleJsonData::checkValidHppResponseSupplementaryData($hppResponseConverted, $this);
    }

    /**
     * Test converting encoded JSON to {@link HppResponse}.
     */
    public function testResponseFromJsonEncodedSuccess()
    {
        $hppResponseExpected = SampleJsonData::generateValidHppResponse();

        $path = SampleJsonData::VALID_HPP_RESPONSE_ENCODED_JSON_PATH;
        $prefix = __DIR__ . '/../../resources';
        $json = file_get_contents($prefix . $path);

        $hppResponseConverted = self::$realex_HPP->responseFromJson($json);

        SampleJsonData::checkValidHppResponse($hppResponseExpected, $hppResponseConverted, $this);
        SampleJsonData::checkValidHppResponseSupplementaryData($hppResponseConverted, $this);
    }

    /**
     * Test converting unencoded JSON to {@link HppResponse}.
     */
    public function testResponseFromJsonDecodedSuccess()
    {
        $hppResponseExpected = SampleJsonData::generateValidHppResponse();

        $path = SampleJsonData::VALID_HPP_RESPONSE_JSON_PATH;
        $prefix = __DIR__ . '/../../resources';
        $json = file_get_contents($prefix . $path);

        $hppResponseConverted = self::$realex_HPP->responseFromJson($json, false);

        SampleJsonData::checkValidHppResponse($hppResponseExpected, $hppResponseConverted, $this);
    }

    /**
     * Test converting unencoded JSON to {@link HppResponse}.
     */
    public function testResponseFromJsonDecodedSuccessWithUnknown()
    {
        $hppResponseExpected = SampleJsonData::generateValidHppResponse();

        $path = SampleJsonData::UNKNOWN_DATA_HPP_RESPONSE_JSON_PATH;
        $prefix = __DIR__ . '/../../resources';
        $json = file_get_contents($prefix . $path);

        $hppResponseConverted = self::$realex_HPP->responseFromJson($json, false);

        SampleJsonData::checkValidHppResponse($hppResponseExpected, $hppResponseConverted, $this);
        SampleJsonData::checkValidHppResponseSupplementaryData($hppResponseConverted, $this);
    }
}
