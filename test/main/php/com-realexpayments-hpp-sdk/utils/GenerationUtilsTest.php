<?php


namespace com\realexpayments\hpp\sdk\utils;


/**
 * Class GenerationUtilsTest
 * @package com\realexpayments\hpp\sdk\utils
 * @author vicpada
 */
class GenerationUtilsTest extends \PHPUnit\Framework\TestCase {

	/**
	 * Test Hash generation success case.
	 */
	public function testGenerateHash() {
		$testString     = "20120926112654.thestore.ORD453-11.00.Successful.3737468273643.79347";
		$secret         = "mysecret";
		$expectedResult = "368df010076481d47a21e777871012b62b976339";

		$result = GenerationUtils::generateHash( $testString, $secret );
		$this->assertTrue( $expectedResult == $result, "Expected and resultant Hash do not match. expected: " . $expectedResult . " result: " . $result );

	}

	/**
	 * Test timestamp generation. Hard to test this in a meaningful way. Checking length and valid characters.
	 */
	public function  testGenerateTimestamp() {


		$result = GenerationUtils::generateTimestamp();

		$count = preg_match( "/[0-9]{14}/", $result, $matches );

		$this->assertTrue( $count == 1, "Timestamp should be 14 digits: " . $result );
	}

	/**
	 * Test order Id generation. Hard to test this in a meaningful way. Checking length and valid characters.
	 */
	public function testGenerateOrderId() {
		$result = GenerationUtils::generateOrderId();

		$this->assertEquals( 22,
			strlen( $result ), "OrderId " . $result . " should be 22 characters, is " . strlen( $result ) . " characters: " . $result );

		$this->assertTrue( preg_match( "/[A-Za-z0-9-_]{22}/", $result ) == 1, "OrderId " . $result . " - Regexp doesn't match [A-Za-z0-9-_]{22}" );
	}



}
