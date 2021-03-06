<?php

namespace Busybee\Core\CalendarBundle\Controller;

use Busybee\Core\TemplateBundle\Controller\BusybeeController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TermController extends BusybeeController
{


	public function deleteAction($id, $year)
	{
		$this->denyAccessUnlessGranted('ROLE_REGISTRAR', null, null);

		$repo = $this->get('busybee_core_calendar.repository.term_repository');

		$term = $repo->find($id);

		if ($term->canDelete())
		{
			$em = $this->get('doctrine')->getManager();
			$em->remove($term);
			$em->flush();
			$this->get('session')->getFlashBag()->add(
				'success',
				$this->get('translator')->trans(
					'year.term.delete.success',
					[
						'%name%' => $term->getName(),
					],
					'BusybeeInstituteBundle')
			);
		}
		else
		{
			$this->get('session')->getFlashBag()->add(
				'warning',
				$this->get('translator')->trans(
					'year.term.delete.warning',
					[
						'%name%' => $term->getName(),
					],
					'BusybeeInstituteBundle')
			);
		}

		return new RedirectResponse($this->generateUrl('year_edit', ['id' => $year, '_fragment' => 'terms']));
	}
}
