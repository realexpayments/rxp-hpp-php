<?php


namespace com\realexpayments\hpp\sdk\validators;


use com\realexpayments\hpp\sdk\domain\HppRequest;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Supplementary data cannot be longer than 255
 *
 * @package com\realexpayments\hpp\sdk\validators
 * @author vicpada
 *
 */
class SupplementaryDataLengthValidator extends ConstraintValidator {


	private $maxLenght = 255;

	/**
	 * Checks if the passed value is valid.
	 *
	 * @param HppRequest $hppRequest
	 * @param Constraint $constraint
	 *
	 * @api
	 */
	public function validate( $hppRequest, Constraint $constraint ) {

		foreach ( $hppRequest->getSupplementaryData() as $supplementaryData ) {
			if ( strlen( $supplementaryData ) > $this->maxLenght ) {
				$this->context->buildViolation( $constraint->message )
				              ->atPath( 'supplementaryData' )
				              ->addViolation();
			}
		}
	}
}