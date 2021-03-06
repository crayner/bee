<?php

namespace Busybee\TimeTableBundle\Form;

use Busybee\Core\SystemBundle\Setting\SettingManager;
use Busybee\TimeTableBundle\Entity\TimeTable;
use Busybee\TimeTableBundle\Events\ColumnSubscriber;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ColumnType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @var SettingManager
     */
    private $sm;

    /**
     * TimeTableType constructor.
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om, SettingManager $sm)
    {
        $this->om = $om;
        $this->sm = $sm;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => TimeTable::class,
                'translation_domain' => 'BusybeeTimeTableBundle',
                'class' => TimeTable::class,
            ]
        );
        $resolver->setRequired(
            [
                'tt_id',
                'locked',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'timetable';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('columns', CollectionType::class,
                [
                    'entry_type' => ColumnPeriodType::class,
                    'entry_options' =>
                        [
                            'tt_id' => $options['tt_id'],
                        ],
                    'disabled' => $options['locked'],
                ]
            )
        ;
        $builder->addEventSubscriber(new ColumnSubscriber($this->om, $this->sm, $options['tt_id']));
    }
}
