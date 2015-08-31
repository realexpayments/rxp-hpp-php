<?php


namespace com\realexpayments\hpp\sdk\validators;


use com\realexpayments\hpp\sdk\domain\HppRequest;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Supplementary should conform to defined character
 *
 * @package com\realexpayments\hpp\sdk\validators
 * @author vicpada
 *
 */
class SupplementaryDataPatternValidator extends ConstraintValidator {

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
			if ( ! preg_match( $constraint->pattern, $supplementaryData ) ) {
				$this->context->buildViolation( $constraint->message )
				              ->atPath( 'supplementaryData' )
				              ->addViolation();
			}
		}
	}
}