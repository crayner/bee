<?php
namespace Busybee\FormBundle\Validator\Constraints ;

use Symfony\Component\Validator\Constraint ;
use Symfony\Component\Validator\Constraints\ChoiceValidator;
use Busybee\SystemBundle\Setting\SettingManager ;
use Symfony\Component\Validator\ConstraintValidator;


class BlankOrValidValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
       return ;
    }
}