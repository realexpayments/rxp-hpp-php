<?php


namespace com\realexpayments\hpp\sdk\utils;


use com\realexpayments\hpp\sdk\domain\HppRequest;
use com\realexpayments\hpp\sdk\RealexValidationException;
use com\realexpayments\hpp\sdk\RPXLogger;
use Logger;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class validates HPP request and response objects.
 *
 * @author vicpada
 */
class ValidationUtils {

	/**
	 * @var Logger logger
	 */
	private static $logger;
	private static $initialised = false;

	/**
	 * @var ValidatorInterface validator
	 */
	private static $validator;


	/**
	 * Method validates HPP request object using JSR-303 bean validation.
	 *
	 * @param HppRequest $hppRequest
	 */
	public static function validate( HppRequest $hppRequest ) {
		self::Initialise();

		$violations = self::$validator->validate( $hppRequest );

		if ( $violations->count() > 0 ) {
			$validationMessages = array();

			foreach ( $violations as $violation ) {

				/* @var ConstraintViolationInterface $violation */
				$validationMessages[] = $violation->getMessage();
			}

			self::$logger->info( "HppRequest failed validation with the following errors: " . $validationMessages );
			throw new RealexValidationException( "HppRequest failed validation", $validationMessages );
		}

	}


	private static function Initialise() {
		if ( self::$initialised ) {
			return;
		}

		self::$logger = RPXLogger::getLogger( __CLASS__ );

		self::$validator = Validation::createValidator();

		self::$initialised = true;
	}
}