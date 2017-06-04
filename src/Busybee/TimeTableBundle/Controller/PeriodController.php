<?php

namespace Busybee\TimeTableBundle\Controller;

use Busybee\TimeTableBundle\Entity\PeriodActivity;
use Busybee\TimeTableBundle\Form\PeriodActivityType;
use Busybee\TimeTableBundle\Form\PeriodPlanType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PeriodController extends Controller
{
    use \Busybee\SecurityBundle\Security\DenyAccessUnlessGranted;

    /**
     * @param $id
     * @param $page
     * @return JsonResponse
     */
    public function removeAction($id, $page)
    {
        $this->denyAccessUnlessGranted('ROLE_REGISTRAR', null, null);

        $period = $this->get('period.repository')->find($id);
        $status = 'success';


        if (empty($period)) {
            return new JsonResponse(
                array(
                    'status' => 'error',
                    'message' => '<div class="alert alert-danger fadeAlert">' . $this->get('translator')->trans('period.remove.missing', [], 'BusybeeTimeTableBundle') . '</div>',
                ),
                200
            );
        }

        $message = '<div class="alert alert-warning fadeAlert">' . $this->get('translator')->trans('period.remove.locked', [], 'BusybeeTimeTableBundle') . '</div>';

        if (!$this->get('period.manager')->canDelete($id))
            return new JsonResponse(
                array(
                    'status' => 'warning',
                    'message' => $message,
                ),
                200
            );

        $om = $this->get('doctrine')->getManager();
        $om->remove($period);
        $om->flush();


        $message = '<div class="alert alert-success fadeAlert">' . $this->get('translator')->trans('period.remove.success', [], 'BusybeeTimeTableBundle') . '</div>';

        return new JsonResponse(
            array(
                'page' => $page,
                'status' => $status,
                'message' => $message,
            ),
            200
        );
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function periodPlanAction($id, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_REGISTRAR', null, null);

        $period = $this->get('period.repository')->find($id);

        $pm = $this->get('period.manager')->injectPeriod($period->getId());

        $form = $this->createForm(PeriodActivityType::class, $period, ['year_data' => $this->get('busybee_security.user_manager')->getSystemYear($this->getUser()), 'manager' => $pm]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $om = $this->get('doctrine')->getManager();
            $om->persist($period);
            $om->flush();
        }

        return $this->render('BusybeeTimeTableBundle:Plan:index.html.twig',
            [
                'form' => $form->createView(),
                'fullForm' => $form,
                'period' => $pm,
            ]
        );
    }

    /**
     * @param $id Period Id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reportAction($id)
    {
        $this->denyAccessUnlessGranted('ROLE_REGISTRAR', null, null);

        $pm = $this->get('period.manager');

        $report = $pm->generatePeriodReport($id);

        return $this->render('BusybeeTimeTableBundle:Plan:report.html.twig',
            [
                'report' => $report,
                'manager' => $pm,
            ]
        );
    }

    /**
     * @param $id
     * @param $line
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addActivitiesToPlanAction($id, $line)
    {
        $this->denyAccessUnlessGranted('ROLE_REGISTRAR', null, null);

        $period = $this->get('period.repository')->find($id);

        $pm = $this->get('period.manager')->injectPeriod($period);

        $pm->injectLineGroup($line);

        return $this->redirect($this->generateUrl('period_plan', ['id' => $id]));
    }

    /**
     * @param $id
     * @param $activity
     * @return JsonResponse
     */
    public function removePeriodActivityAction($id, $activity)
    {
        $this->denyAccessUnlessGranted('ROLE_REGISTRAR', null, null);

        $period = $this->get('period.repository')->find($id);

        $pa = $this->get('period.activity.repository')->find($activity);

        $name = $pa->getActivity()->getFullName();

        $period->getActivities()->removeElement($pa);

        $om = $this->get('doctrine')->getManager();

        $om->persist($period);
        $om->remove($pa);
        $om->flush();

        return new JsonResponse(
            array(
                'message' => '<div class="alert alert-success">' . $this->get('translator')->trans('period.activities.activity.remove.success', ['%name%' => $name], 'BusybeeTimeTableBundle') . '</div>',
                'status' => 'success',
            ),
            200
        );
    }

    public function editPeriodActivityAction($activity)
    {
        $this->denyAccessUnlessGranted('ROLE_REGISTRAR', null, null);

        $period = $this->get('period.repository')->find($id);
}