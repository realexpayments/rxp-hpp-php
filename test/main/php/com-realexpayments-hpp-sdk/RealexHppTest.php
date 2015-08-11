<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 11/08/2015
 * Time: 18:46
 */

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
}
