<?php

namespace com\realexpayments\hpp\sdk\utils;


use com\realexpayments\hpp\sdk\domain\HppResponse;

class ResponseMapper implements iMapper {
	private static $KNOWN_FIELDS = array(
		'MERCHANT_ID',
		'ACCOUNT',
		'ORDER_ID',
		'AUTHCODE',
		'AMOUNT',
		'AUTH_CODE',
		'TIMESTAMP',
		'SHA1HASH',
		'RESULT',
		'MESSAGE',
		'CVNRESULT',
		'PASREF',
		'BATCHID',
		'ECI',
		'CAVV',
		'XID',
		'COMMENT1',
		'COMMENT2',
		'TSS',
		'AVSADDRESSRESULT',
		'AVSPOSTCODERESULT'

	);

	/**
	 *
	 * Receives a domain object and generates a Json string
	 *
	 * @param HppResponse $hppResponse
	 *
	 * @return string
	 */
	public function  WriteValueAsString( $hppResponse ) {

		$prop = array(
			'MERCHANT_ID'       => $hppResponse->getMerchantId(),
			'ACCOUNT'           => $hppResponse->getAccount(),
			'ORDER_ID'          => $hppResponse->getOrderId(),
			'AMOUNT'            => $hppResponse->getAmount(),
			'AUTHCODE'          => $hppResponse->getAuthCode(),
			'TIMESTAMP'         => $hppResponse->getTimeStamp(),
			'SHA1HASH'          => $hppResponse->getHash(),
			'RESULT'            => $hppResponse->getResult(),
			'MESSAGE'           => $hppResponse->getMessage(),
			'CVNRESULT'         => $hppResponse->getCvnResult(),
			'PASREF'            => $hppResponse->getPasRef(),
			'BATCHID'           => $hppResponse->getBatchId(),
			'ECI'               => $hppResponse->getEci(),
			'CAVV'              => $hppResponse->getCavv(),
			'XID'               => $hppResponse->getXid(),
			'COMMENT1'          => $hppResponse->getCommentOne(),
			'COMMENT2'          => $hppResponse->getCommentTwo(),
			'TSS'               => $hppResponse->getTss(),
			'AVSADDRESSRESULT'  => $hppResponse->getAVSAddressResult(),
			'AVSPOSTCODERESULT' => $hppResponse->getAVSPostCodeResult()
		);


		foreach ( $hppResponse->getSupplementaryData() as $key => $value ) {
			$prop[ $key ] = $value;
		}

		return json_encode( $prop );
	}


	/**
	 *
	 * Receives a Json string and generates a domain object
	 *
	 * @param string $value
	 *
	 * @return HppResponse
	 */
	public function  ReadValue( $value ) {
		$array = json_decode( $value, true );
		$array = new SafeArrayAccess( $array, "" );

		if ( $array ) {

			$hppResponse = new HppResponse();

			$hppResponse->setMerchantId( $array['MERCHANT_ID'] );
			$hppResponse->setAccount( $array['ACCOUNT'] );
			$hppResponse->setOrderId( $array['ORDER_ID'] );
			$hppResponse->setAmount( $array['AMOUNT'] );
			$hppResponse->setAuthCode( $array['AUTHCODE'] );
			$hppResponse->setTimeStamp( $array['TIMESTAMP'] );
			$hppResponse->setHash( $array['SHA1HASH'] );
			$hppResponse->setResult( $array['RESULT'] );
			$hppResponse->setMessage( $array['MESSAGE'] );
			$hppResponse->setCvnResult( $array['CVNRESULT'] );
			$hppResponse->setPasRef( $array['PASREF'] );
			$hppResponse->setBatchId( $array['BATCHID'] );
			$hppResponse->setEci( $array['ECI'] );
			$hppResponse->setCavv( $array['CAVV'] );
			$hppResponse->setXid( $array['XID'] );
			$hppResponse->setCommentOne( $array['COMMENT1'] );
			$hppResponse->setCommentTwo( $array['COMMENT2'] );
			$hppResponse->setTss( $array['TSS'] );
			$hppResponse->setAVSAddressResult( $array['AVSADDRESSRESULT'] );
			$hppResponse->setAVSPostCodeResult( $array['AVSPOSTCODERESULT'] );


			foreach ( $array->getUnderLayingArray() as $key => $value ) {

				if ( ! $this->isKnownProperty( $key ) ) {
					$hppResponse->setSupplementaryDataValue( $key, $value );
				}
			}

			return $hppResponse;
		}

		return $array;
	}

	private function isKnownProperty( $key ) {
		return in_array( strtoupper( $key ), self::$KNOWN_FIELDS );
	}


}