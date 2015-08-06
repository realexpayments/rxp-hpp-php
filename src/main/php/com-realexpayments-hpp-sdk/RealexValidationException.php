<?php


namespace com\realexpayments\hpp\sdk;

use RuntimeException;


/**
 * An exception class for general Realex SDK validation errors.
 *
 * @author vicpada
 *
 */
class RealexValidationException extends RuntimeException {

	const serialVersionUID = - 5328243688578577594;

	/*
	 * @var string[] List of validation messages.
	 */
	private $validationMessages;

	/**
	 * Getter for validationMessages
	 *
	 * @return string[]
	 */
	public function getValidationMessages() {
		return $this->validationMessages;
	}


	/**
	 * RealexValidationException constructor.
	 *
	 * @param string $message
	 * @param string[] $validationMessages
	 */
	public function __construct( $message, array $validationMessages = array() ) {
		parent::__construct( $message );

		$this->validationMessages = $validationMessages;
	}


}