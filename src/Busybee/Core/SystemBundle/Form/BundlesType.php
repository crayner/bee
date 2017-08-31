<?php

namespace Busybee\Core\SystemBundle\Form;

use Busybee\Core\SystemBundle\Event\BundlesSubscriber;
use Busybee\Core\SystemBundle\Model\BundleManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BundlesType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('bundles', CollectionType::class,
				[
					'entry_type'    => BundleType::class,
					'attr'          => [
						'class' => 'bundleCollection',
					],
					'allow_add'     => false,
					'allow_delete'  => false,
					'entry_options' => [
						'bundleList' => $options['data']->getBundleList(),
						'manager'    => $options['data'],
					],
				]
			);
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'translation_domain' => 'SystemBundle',
			'data_class'         => BundleManager::class,
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix()
	{
		return 'bundles_manage';
	}

	public function buildView(FormView $view, FormInterface $form, array $options)
	{
		$view->vars['manager'] = $options['data'];

	}
}
