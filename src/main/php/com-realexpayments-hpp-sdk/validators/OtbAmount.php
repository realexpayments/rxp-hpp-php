<?php

namespace com\realexpayments\hpp\sdk\validators;


use Symfony\Component\Validator\Constraint;

/**
 * /**
 * OTB amount validator. Amount must be set to 0 for OTB transactions.
 * For OTB transactions the validate card only flag is set to 1.
 *
 * @author vicpada
 * @Annotation
 */
class OtbAmount extends Constraint
{
    public $message = ValidationMessages::hppRequest_amount_otb;


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