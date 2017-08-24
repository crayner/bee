<?php

namespace Busybee\People\StaffBundle\Controller;

use Busybee\People\PersonBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class StaffController extends Controller
{
	use \Busybee\Core\SecurityBundle\Security\DenyAccessUnlessGranted;

	/**
	 * @param $id
	 *
	 * @return JsonResponse
	 */
	public function toggleAction($id)
	{
		$this->denyAccessUnlessGranted('ROLE_REGISTRAR', null, null);

		$person = $this->get('person.repository')->find($id);

		if (!$person instanceof Person)
			return new JsonResponse(
				array(
					'message' => '<div class="alert alert-danger fadeAlert">' . $this->get('translator')->trans('staff.toggle.personMissing', array(), 'BusybeeStaffBundle') . '</div>',
					'status'  => 'failed'
				),
				200
			);
		$em = $this->get('doctrine')->getManager();
		if ($person->getStaffQuestion())
		{
			if ($this->get('person.manager')->canDeleteStaff($person))
			{
				$this->get('person.manager')->deleteStaff($person);

				return new JsonResponse(
					array(
						'message' => '<div class="alert alert-success fadeAlert">' . $this->get('translator')->trans('staff.toggle.removeSuccess', array('%name%' => $person->formatName()), 'BusybeeStaffBundle') . '</div>',
						'status'  => 'removed',
					),
					200
				);
			}
			else
			{
				return new JsonResponse(
					array(
						'message' => '<div class="alert alert-warning fadeAlert">' . $this->get('translator')->trans('staff.toggle.removeRestricted', array('%name%' => $person->formatName()), 'BusybeeStaffBundle') . '</div>',
						'status'  => 'failed',
					),
					200
				);
			}
		}
		else
		{
			if (!$person->getStaffQuestion() && $this->get('person.manager')->canBeStaff($person))
			{
				$this->get('person.manager')->createStaff($person);

				return new JsonResponse(
					array(
						'message' => '<div class="alert alert-success fadeAlert">' . $this->get('translator')->trans('staff.toggle.addSuccess', array('%name%' => $person->formatName()), 'BusybeeStaffBundle') . '</div>',
						'status'  => 'added',
					),
					200
				);
			}
			else
			{
				return new JsonResponse(
					array(
						'message' => '<div class="alert alert-warning fadeAlert">' . $this->get('translator')->trans('staff.toggle.addRestricted', array('%name%' => $person->formatName()), 'BusybeePersonBundle') . '</div>',
						'status'  => 'failed',
					),
					200
				);
			}
		}
	}

	/**
	 * @param Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function listAction(Request $request)
	{
		$this->denyAccessUnlessGranted('ROLE_ADMIN');

		$up = $this->get('staff.pagination');

		$up->injectRequest($request);

		$up->getDataSet();

		return $this->render('BusybeeStaffBundle:Staff:index.html.twig',
			array(
				'pagination' => $up,
			)
		);
	}
}