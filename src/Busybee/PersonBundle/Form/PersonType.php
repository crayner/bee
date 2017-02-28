<?php

namespace Busybee\PersonBundle\Form ;

use Busybee\FormBundle\Type\AutoCompleteType;
use Busybee\FormBundle\Type\ImageType;
use Busybee\FormBundle\Type\SettingChoiceType;
use Busybee\FormBundle\Type\YesNoType;
use Busybee\PersonBundle\Entity\Address;
use Busybee\PersonBundle\Events\PersonSubscriber;
use Busybee\PersonBundle\Model\PersonManager;
use Busybee\PersonBundle\Model\PhotoUploader;
use Symfony\Component\Form\AbstractType ;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface ;
use Symfony\Component\OptionsResolver\OptionsResolver ;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Persistence\ObjectManager ;


class PersonType extends AbstractType
{
	/**
	 * @var	PersonManager
	 */
	private $personManager ;

    /**
     * @var	ObjectManager
     */
    private $manager ;

    /**
     * @var	PhotoUpLoader
     */
    private $photoLoader ;

    /**
     * @var array
     */
    private $parameters ;

	/**
	 * Construct
	 */
    public function __construct(PersonManager $sm, ObjectManager $manager, PhotoUploader $photoLoader, $parameters)
	{
		$this->personManager = $sm ;
		$this->manager = $manager ;
		$this->photoLoader = $photoLoader;
        $this->parameters = $parameters;
	}

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', SettingChoiceType::class, array(
					'label' => 'person.label.title',
                'settingName' => 'Person.TitleList',
					'attr'	=> array(
						'class' => 'beeTitle',
					),
					'required' => false,
				)
			)
            ->add('surname', null, array(
                    'label' => 'person.label.surname',
                    'attr'	=> array(
                        'class' => 'beeSurname',
                    ),
                )
            )
			->add('firstName', null, array(
					'label' => 'person.label.firstName',
					'attr'	=> array(
						'class' => 'beeFirstName',
					),
				)
			)
			->add('preferredName', null, array(
					'label' => 'person.label.preferredName',
					'attr'	=> array(
						'class' => 'beePreferredName',
					),
					'required' => false,
				)
			)
			->add('officialName', null, array(
					'label' => 'person.label.officialName',
					'attr' => array(
						'help' => 'person.help.officialName',
						'class' => 'beeOfficialName',
					),
				)
			)
            ->add('gender', SettingChoiceType::class, array(
                    'settingName' => 'Person.GenderList',
					'label' => 'person.label.gender',
					'attr'	=> array(
						'class' => 'beeGender',
					),
				)
			)
            ->add('dob', BirthdayType::class, array(
					'label' => 'person.dob.label',
					'required' => false,
					'attr'	=> array(
						'class' => 'beeDob',
					),
				)
			)
            ->add('email', EmailType::class, array(
					'label' => 'person.label.email',
					'required' => false,
				)
			)
            ->add('email2', EmailType::class, array(
					'label' => 'person.label.email2',
					'required' => false,
				)
			)
            ->add('photo', ImageType::class, array(
					'attr' => array(
						'help' => 'person.help.photo' ,
						'imageClass' => 'headShot75',
					),
					'label' => 'person.label.photo',
					'required' => false,
                    'deletePhoto' => $options['data']->deletePhoto,
				)
			)
            ->add('website', UrlType::class, array(
					'label' => 'person.label.website',
					'required' => false,
				)
			)
			->add('address1', AutoCompleteType::class,
                array(
                    'class' => Address::class,
                    'data'  =>  $options['data']->getAddress1(),
                    'choice_label' => 'singleLineAddress',
                    'empty_data'  => null,
                    'required' => false,
                    'attr' => array(
                        'help' => 'person.help.address1',
                        'class' => 'beeAddressList formChanged',
                    ),
                )
            )
            ->add('address2', AutoCompleteType::class,
                array(
                    'class' => Address::class,
                    'choice_label' => 'singleLineAddress',
                    'data'  => $options['data']->getAddress2(),
                    'empty_data'  => null,
                    'required' => false,
                    'attr' => array(
                        'help' => 'person.help.address2',
                        'class' => 'beeAddressList formChanged',
                    ),
                )
            )
            ->add('phone', CollectionType::class, array(
                    'label'					=> 'person.label.phones',
                    'entry_type'			=> PhoneType::class,
                    'allow_add'				=> true,
                    'by_reference'			=> false,
                    'allow_delete'			=> true,
                    'attr'                  => array(
                        'class'                 => 'phoneNumberList'
                    ),
                    'translation_domain' => 'BusybeePersonBundle',
                )
            )
            ->add('staffQuestion', YesNoType::class, array(
                    'label'					=> 'person.label.staff.question',
                    'attr'                  => array(
                        'help'                  => 'person.help.staff.question',
                        'data-off-icon-cls'	 	=> "halflings-thumbs-down",
                        'data-on-icon-cls' 		=> "halflings-thumbs-up",
                    ),
                )
            )
            ->add('studentQuestion', YesNoType::class, array(
                    'label'					=> 'person.label.student.question',
                    'attr'                  => array(
                        'help'                  => 'person.help.student.question',
                        'data-off-icon-cls'	 	=> "halflings-thumbs-down",
                        'data-on-icon-cls' 		=> "halflings-thumbs-up",
                    ),
                )
            )
            ->add('userQuestion', YesNoType::class, array(
                    'label'					=> 'person.label.user.question',
                    'attr'                  => array(
                        'help'                  => 'person.help.user.question',
                        'data-off-icon-cls'	 	=> "halflings-thumbs-down",
                        'data-on-icon-cls' 		=> "halflings-thumbs-up",
                    ),
                    'mapped'                => false,
                )
            )
		;

        $builder->addEventSubscriber(new PersonSubscriber($this->personManager, $this->manager, $this->parameters));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
			array(
				'data_class' 			=> 'Busybee\PersonBundle\Entity\Person',
				'translation_domain'	=> 'BusybeePersonBundle',
				'allow_extra_fields' 	=> true,
			)
		);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'person';
    }
    /**
     * {@inheritdoc}
     */
    public function getYears()
    {
        $years = array();
		for($i=-100; $i<=0; $i++)
		{
			$years[] = date('Y', strtotime($i.' Years'));
		}
		return $years ;
    }
}
