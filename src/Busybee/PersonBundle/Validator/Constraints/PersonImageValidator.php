<?php
namespace Busybee\PersonBundle\Validator\Constraints ;

use Symfony\Component\Validator\Constraint ;
use Symfony\Component\Validator\Constraints\ImageValidator ;


class PersonImageValidator extends ImageValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (empty($value))
            return ;

		parent::validate($value, $constraint);
    }
}