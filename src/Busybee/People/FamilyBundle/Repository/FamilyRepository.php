<?php

namespace Busybee\People\FamilyBundle\Repository;

use Busybee\People\FamilyBundle\Entity\Family;

/**
 * FamilyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FamilyRepository extends \Doctrine\ORM\EntityRepository
{
	public function find($id)
	{
		$family = parent::find($id);

		return $family instanceof Family ? $family : new Family();
	}

	public function findByStudents($student)
	{
		$result = $this->createQueryBuilder('f')
			->leftJoin('f.students', 's')
			->where('s.id = :student')
			->setParameter('student', $student)
			->getQuery()
			->getResult();

		return $result;
	}
}