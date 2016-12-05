<?php

namespace Busybee\InstituteBundle\Controller ;

use Symfony\Bundle\FrameworkBundle\Controller\Controller ;
use Symfony\Component\HttpFoundation\Request ;
use Busybee\InstituteBundle\Form\YearType ;
use Busybee\InstituteBundle\Entity\Year ;
use Symfony\Component\HttpFoundation\RedirectResponse ;

class CalendarController extends Controller
{
    public function yearsAction()
    {
		$this->denyAccessUnlessGranted('ROLE_REGISTRAR', null, 'Unable to access this page!');
		
		$repo = $this->get('year.repository');
		
		$years = $repo->findBy(array(), array('firstDay'=>'ASC', 'lastDay'=>'ASC'));

		return $this->render('BusybeeInstituteBundle:Calendar:years.html.twig', array('Years' => $years));
    }

    public function editYearAction($id, Request $request)
    {
		$this->denyAccessUnlessGranted('ROLE_REGISTRAR', null, 'Unable to access this page!');
		
		$repo = $this->get('year.repository');
		
		if ($id === 'Add')
			$year = new Year();
		else
			$year = $repo->find($id);
		
		$year->cancelURL = $this->get('router')->generate('calendar_years');
 
        $form = $this->createForm(YearType::class, $year);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid())
		{
			$em = $this->get('doctrine')->getManager();
			$em->persist($year);
			$em->flush();
			$id = $year->getId();
			
			return new RedirectResponse($this->generateUrl('year_edit', array('id' => $id)));
		} 
		
		return $this->render('BusybeeInstituteBundle:Calendar:calendar.html.twig', 
			array(
				'form' 			=> $form->createView(),
				'fullForm'		=> $form,
				'id'			=> $id,
			)
		);
    }

    public function deleteYearAction($id)
    {
		$this->denyAccessUnlessGranted('ROLE_REGISTRAR', null, 'Unable to access this page!');
		
		$repo = $this->get('year.repository');
		
		$year = $repo->find($id);
	
		$em = $this->get('doctrine')->getManager();
		$em->remove($year);
		$em->flush();
		
		return new RedirectResponse($this->generateUrl('calendar_years'));
    }

    public function deleteSpecialDayAction($id, $year)
    {
		$this->denyAccessUnlessGranted('ROLE_REGISTRAR', null, 'Unable to access this page!');
		
		$repo = $this->get('specialDay.repository');
		
		$day = $repo->find($id);
	
		$em = $this->get('doctrine')->getManager();
		$em->remove($day);
		$em->flush();
		
		return new RedirectResponse($this->generateUrl('year_edit', array('id' => $year)));
    }

    public function deleteTermAction($id, $year)
    {
		$this->denyAccessUnlessGranted('ROLE_REGISTRAR', null, 'Unable to access this page!');
		
		$repo = $this->get('term.repository');
		
		$term = $repo->find($id);
	
		$em = $this->get('doctrine')->getManager();
		$em->remove($term);
		$em->flush();
		
		return new RedirectResponse($this->generateUrl('year_edit', array('id' => $year)));
    }

    public function calendarAction($id)
    {
		$this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');
	
        $now = new \DateTime();
		
		$repo = $this->get('year.repository');
		
		$year = $repo->find($id);
		
        $service = $this->get('calendar.widget'); //calling a calendar service

        //Defining a custom classes for rendering of months and days
        $dayModelClass = '\Busybee\InstituteBundle\Model\Day';
        $monthModelClass = '\Busybee\InstituteBundle\Model\Month';
        /*
         * Set model classes for calendar. Arguments:
         * 1. For the whole calendar (watch $calendar variable). Default: \TFox\CalendarBundle\Service\WidgetService\Calendar
         * 2. Month. Default: \TFox\CalendarBundle\Service\WidgetService\Month
         * 3. Week. Default: '\TFox\CalendarBundle\Service\WidgetService\Week
         * 4. Day. Default: '\TFox\CalendarBundle\Service\WidgetService\Day'
         * To set default classes null should be passed as argument
         */
        $service->setModels(null, $monthModelClass, null, $dayModelClass);
        $calendar = $service->generateCalendar($year->getFirstDay()->format('Y')); //Generate a calendar for specified year
        /*
         * Get the 26th of December and make it hodiday.
         * Function setIsHoliday is defined in a class which 
         * extends default \TFox\CalendarBundle\Service\WidgetService\Day class
         */
        $calendar->getDay('01.01')->setIsHoliday(true);
        $calendar->getDay('25.04')->setIsHoliday(true);
        $calendar->getDay('13.06')->setIsHoliday(true);
        $calendar->getDay('25.12')->setIsHoliday(true);
        $calendar->getDay('26.12')->setIsHoliday(true);
        $calendar->getDay('26.01')->setIsHoliday(true);
        $calendar->getDay('27.12')->setIsHoliday(true);
        $calendar->getDay('15.04')->setIsHoliday(true);
        $calendar->getDay('17.04')->setIsHoliday(true);
        $calendar->getDay('18.04')->setIsHoliday(true);
        $calendar->getDay('03.10')->setIsHoliday(true);

        /*
         * Another way to pass additional parametes without extension of default model
         * Sets the parameter 'today' for current day
         */
//        $calendar->getDay($now->format('d.m'))->setParameter('today', 1);

        /*
         * Pass calendar to Twig
         */
		return $this->render('BusybeeInstituteBundle:Calendar:yearCalendar.html.twig', 
			array(
				'calendar'	=> $calendar,
				'year'		=> $year,
			)
		);
	}
}
