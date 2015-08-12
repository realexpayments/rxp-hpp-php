<?php

namespace com\realexpayments\hpp\sdk\validators;


use com\realexpayments\hpp\sdk\domain\Flag;
use com\realexpayments\hpp\sdk\domain\HppRequest;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * OTB amount validator. Amount must be set to 0 for OTB transactions.
 * For OTB transactions the validate card only flag is set to 1.
 *
 * @package com\realexpayments\hpp\sdk\validators
 * @author vicpada
 *
 */
class OtbAmountValidator extends ConstraintValidator
{


    /**
     * Validates OTB
     *
     * @param HppRequest $hppRequest
     * @param Constraint $constraint
     * @return bool
     */
    public function validate($hppRequest, Constraint $constraint)
    {

        //if validate card only flag is true (1), then ensure the amount is set to 0
        if (Flag::TRUE == $hppRequest->getValidateCardOnly()) {
            if ($hppRequest->getAmount() != "0") {
                $this->context->buildViolation($constraint->message)
                    ->atPath('amount')
                    ->addViolation();

            }
        }

    }
}