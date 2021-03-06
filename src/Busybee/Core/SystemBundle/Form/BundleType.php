<?php

namespace Busybee\Core\SystemBundle\Form;

use Busybee\Core\TemplateBundle\Type\CollectionChoiceType;
use Busybee\Core\TemplateBundle\Type\ToggleType;
use Busybee\Core\SystemBundle\Form\Transformer\BundleTypeTransformer;
use Busybee\Core\SystemBundle\Model\Bundle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BundleType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', HiddenType::class)
			->add('active', ToggleType::class,
				[
					'label' => 'system.bundle.active.label',
					'attr'  => [
						'data-height' => 28,
						'data-size'   => 'mini',
						'data-width'  => 45,
					],
				]
			)
			->add('namespace', HiddenType::class)
			->add('description', HiddenType::class);
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(
			[
				'translation_domain' => 'SystemBundle',
				'data_class'         => Bundle::class,
			]
		);
		$resolver->setRequired(
			[
				'bundleList',
				'manager',   // Bundle Manager
			]
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix()
	{
		return 'bundleType';
	}

	public function buildView(FormView $view, FormInterface $form, array $options)
	{
		$view->vars['manager'] = $options['manager'];
	}
}
