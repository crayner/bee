<?php

namespace Busybee\Core\SystemBundle\Form;

use Busybee\Core\SystemBundle\Model\HouseManager;
use Busybee\Core\SystemBundle\Validator\Houses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HousesType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('houses', CollectionType::class,
				[
					'entry_type'   => HouseType::class,
					'attr'         => [
						'class' => 'houseCollection',
					],
					'allow_add'    => true,
					'allow_delete' => true,
					'constraints'  => [
						new Houses(),
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
			'data_class'         => HouseManager::class,
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix()
	{
		return 'houses_manage';
	}
}
