<?php

namespace Busybee\TimeTableBundle\Events;

use Busybee\TimeTableBundle\Form\ActivitiesEntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LineSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_submit
        // event and that the preSubmit method should be called.
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit',
        );
    }

    /**
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (!empty($data->getYear())) {
            $year = $data->getYear();
            $form->add('activities', CollectionType::class, [
                    'attr' => [
                        'help' => 'line.help.activities',
                        'class' => 'activityList',
                    ],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'label' => 'line.label.activities',
                    'entry_type' => ActivitiesEntityType::class,
                    'entry_options' => [
                        'query_builder' => function (EntityRepository $er) use ($year) {
                            return $er->createQueryBuilder('a')
                                ->leftJoin('a.year', 'y')
                                ->orderBy('a.name', 'ASC')
                                ->where('y.id = :year_id')
                                ->setParameter('year_id', $year->getId());
                        },
                    ],
                ]
            );

        }

        $event->setData($data);
    }

    /**
     * @param FormEvent $event
     */
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();

        $data['nameShort'] = empty($data['nameShort']) ? '' : preg_replace('/\s/', '', strtoupper($data['nameShort']));

        $event->setData($data);
    }
}