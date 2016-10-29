<?php

namespace Busybee\PersonBundle\Form ;

use Symfony\Component\Form\AbstractType ;
use Symfony\Component\Form\FormBuilderInterface ;
use Symfony\Component\OptionsResolver\OptionsResolver ;
use Symfony\Component\Intl\Locale\Locale ;
use Symfony\Component\Form\FormEvent ;
use Symfony\Component\Form\FormEvents ;

class LocalityType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('locality', null, array(
					'label' => 'locality.label.locality',
					'required' => false,
					'attr' => array(
						'class' => 'beeLocality'.$options['data']->getName(),
					),
				)
			)
			->add('territory', null, array(
					'label' => 'locality.label.territory',
					'required' => false,
					'attr' => array(
						'class' => 'beeTerritory'.$options['data']->getName(),
					),
				)
			)
			->add('postCode', null, array(
					'label' => 'locality.label.postcode',
					'required' => false,
					'attr' => array(
						'class' => 'beePostCode'.$options['data']->getName(),
					),
				)
			)
			->add('country', 'Symfony\Component\Form\Extension\Core\Type\CountryType', array(
					'label' => 'locality.label.country',
					'required' => false,
					'attr' => array(
						'class' => 'beeCountry'.$options['data']->getName(),
					),
				)
			)
			->add('localityList', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', 
				array(
					'data_class' => 'Busybee\PersonBundle\Entity\Locality',
					'choices' => $options['data']->repo->getLocalityChoices(),
					'label' => 'locality.label.choice',
					'placeholder' => 'locality.placeholder.choice',
					'empty_data'  => null,
					'required' => false,
					'attr' => array(
						'help' => 'locality.help.choice',
						'class' => 'beeLocalityList'.$options['data']->getName(),
					),
					'mapped' => false,
					'translation_domain' => 'BusybeePersonBundle',
				)
			)
			->add('save', 'Symfony\Component\Form\Extension\Core\Type\ButtonType', array(
					'label'					=> 'locality.label.save', 
					'attr' 					=> array(
						'class' 				=> 'beeLocalitySave'.$options['data']->getName().' btn btn-info glyphicons glyphicons-plus-sign',
					),
				)
			)
		;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
			array (
				'data_class' => 'Busybee\PersonBundle\Entity\Locality',
				'translation_domain' => 'BusybeePersonBundle',
				'allow_extra_fields' => true,
			)
		);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'locality';
    }
}