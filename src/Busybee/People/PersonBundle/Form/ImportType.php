<?php

namespace Busybee\People\PersonBundle\Form;

use Busybee\Core\TemplateBundle\Type\CSVType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ImportType extends AbstractType
{

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('importFile', CSVType::class,
				array(
					'label'  => 'people.import.importFile.label',
					'mapped' => false,
				)
			)
			->setAction($options['action']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(
			array(
				'data_class'         => null,
				'translation_domain' => 'BusybeePersonBundle',
			)
		);
		$resolver->setRequired(
			[
				'action',
			]
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix()
	{
		return 'import';
	}


}
