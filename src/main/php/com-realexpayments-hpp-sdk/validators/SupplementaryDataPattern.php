<?php


namespace com\realexpayments\hpp\sdk\validators;


use Symfony\Component\Validator\Constraint;

/**
 * Supplementary should conform to defined character
 *
 * @author vicpada
 * @Annotation
 */
class SupplementaryDataPattern extends Constraint{
	public $message = ValidationMessages::hppRequest_supplementary_data_pattern;
	public $pattern = "/^[\x{00C0}\x{00C1}\x{00C2}\x{00C3}\x{00C4}\x{00C5}\x{00C6}\x{00C7}\x{00C8}\x{00C9}\x{00CA}\x{00CB}\x{00CC}\x{00CD}\x{00CE}\x{00CF}\x{00D0}\x{00D1}\x{00D2}\x{00D3}\x{00D4}\x{00D5}\x{00D6}\x{00D7}\x{00D8}\x{00D9}\x{00DA}\x{00DB}\x{00DC}\x{00DD}\x{00DE}\x{00DF}\x{00E0}\x{00E1}\x{00E2}\x{00E3}\x{00E4}\x{00E5}\x{00E6}\x{00E7}\x{00E8}\x{00E9}\x{00EA}\x{00EB}\x{00EC}\x{00ED}\x{00EE}\x{00EF}\x{00F0}\x{00F1}\x{00F2}\x{00F3}\x{00F4}\x{00F5}\x{00F6}\x{00F7}\x{00F8}\x{00A4}\x{00F9}\x{00FA}\x{00FB}\x{00FC}\x{00FD}\x{00FE}\x{00FF}\x{0152}\x{017D}\x{0161}\x{0153}\x{017E}\x{0178}\x{00A5}a-zA-Z0-9\'\,\+\x{0022}\.\_\-\&\/\@\!\?\%\()\*\:\x{00A3}\$\&\x{20AC}\#\[\]\|\=\\\x{201C}\x{201D}\x{201C} ]*$/iu";

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