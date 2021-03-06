<?php
namespace Busybee\Core\HomeBundle\Validator;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator as ConstraintValidatorBase;

class TwigValidator extends ConstraintValidatorBase
{
	public function validate($value, Constraint $constraint)
	{

		if (empty($value))
			return;

		$message = '';
		try
		{
			$tplName = uniqid('string_template_', true);
			$twig    = new \Twig_Environment(new \Twig_Loader_Array([$tplName => $value]));
			$twig->setCache(false);
			$test = new Response($twig->render($tplName));
		}
		catch (\Exception $e)
		{
			$message = $e->getMessage();
		}

		if (!empty($message))
		{
			$this->context->buildViolation($constraint->message)
				->setParameter('%systemMessage%', $message)
				->addViolation();
		}
	}
}