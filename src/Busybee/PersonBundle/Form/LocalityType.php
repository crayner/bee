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
				)
			)
			->add('territory', null, array(
					'label' => 'locality.label.territory',
					'required' => false,
				)
			)
			->add('postCode', null, array(
					'label' => 'locality.label.postcode',
					'required' => false,
				)
			)
			->add('country', 'Symfony\Component\Form\Extension\Core\Type\CountryType', array(
					'label' => 'locality.label.country',
					'required' => false,
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
					),
					'mapped' => false,
					'translation_domain' => 'BusybeePersonBundle',
				)
			)
			->add('save', 'Symfony\Component\Form\Extension\Core\Type\ButtonType', array(
					'label'					=> 'form.save', 
					'translation_domain' 	=> 'BusybeeHomeBundle',
					'attr' 					=> array(
						'class' 				=> 'btn btn-info glyphicons glyphicons-plus-sign',
					),
				)
			)
			->addEventListener(
                FormEvents::PRE_SUBMIT,
                array($this, 'saveWhat')
            )        ;
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
        return 'busybee_locality';
    }

	/**
	 * Save What
	 *
	 * @version	28th October 2016
	 * @since	28th October 2016
	 * @param	FormEvent	$event
	 * @return 
	 */
	public function saveWhat(FormEvent $event)
	{
		dump($event);
	}
}
