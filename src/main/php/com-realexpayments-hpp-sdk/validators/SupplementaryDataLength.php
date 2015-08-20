<?php


namespace com\realexpayments\hpp\sdk\validators;


use Symfony\Component\Validator\Constraint;

/**
 * Supplementary data cannot be longer than 255
 *
 * @author vicpada
 * @Annotation
 */
class SupplementaryDataLength  extends Constraint{
	public $message = ValidationMessages::hppRequest_supplementary_data_size;

	/**
	 * @inheritdoc
	 */
	public function validatedBy()
	{
		return get_class($this) . 'Validator';
	}

	public function getTargets()
	{
		return self::CLASS_CONSTRAINT;
	}
}