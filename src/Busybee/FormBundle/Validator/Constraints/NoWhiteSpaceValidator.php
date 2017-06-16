<?php

namespace Busybee\FormBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class NoWhiteSpaceValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $value = preg_replace('/\s/', '', $value);

        if (preg_match('/\s/', $value))
            $this->context->buildViolation($constraint->message)
                ->setParameter('%value%', $value)
                ->addViolation();

        return $value;
    }
}