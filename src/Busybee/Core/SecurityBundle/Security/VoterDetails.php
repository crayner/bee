<?php

namespace Busybee\Core\SecurityBundle\Security;

use Busybee\Core\HomeBundle\Exception\Exception;
use Busybee\People\PersonBundle\Entity\Person;
use Busybee\People\PersonBundle\Model\PersonInterface;
use Busybee\People\PersonBundle\Model\PersonManager;
use Busybee\Core\SecurityBundle\Entity\User;
use Busybee\People\StaffBundle\Entity\Staff;
use Busybee\ActivityBundle\Entity\Activity;
use Busybee\People\StudentBundle\Entity\Student;
use Busybee\TimeTableBundle\Entity\PeriodActivity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

class VoterDetails
{
	/**
	 * @var ArrayCollection
	 */
	private $grades;

	/**
	 * @var Student
	 */
	private $student;

	/**
	 * @var Staff
	 */
	private $staff;

	/**
	 * @var Activity
	 */
	private $activity;

	/**
	 * @var string|null
	 */
	private $identifierType;

	/**
	 * @var ObjectManager
	 */
	private $om;

	/**
	 * VoterDetails constructor.
	 */
	public function __construct(ObjectManager $om)
	{
		$this->grades         = new ArrayCollection();
		$this->student        = null;
		$this->activity       = null;
		$this->staff          = null;
		$this->om             = $om;
		$this->identifierType = null;
	}

	public function parseIdentifier($identifier)
	{
		$this->addGrade($identifier)
			->addStudent($identifier)
			->addStaff($identifier)
			->setIdentifierType($identifier);

		return $this;
	}

	/**
	 * Add Staff
	 *
	 * @param $staff
	 *
	 * @return VoterDetails
	 */
	public function addStaff($staff): VoterDetails
	{
		if ($staff instanceof User)
			$staff = $staff->getPerson();

		if ($staff instanceof Person)
			$staff = $staff->getStaff();

		if ($staff instanceof Staff)
			return $this->setStaff($staff);

		if (substr($staff, 0, 4) !== 'staf')
			return $this->setStaff(null);

		$id = intval(substr($staff, 4));

		if (gettype($id) !== 'integer' || empty($id))
			return $this->setStaff(null);

		$staff = $this->om->getRepository(Staff::class)->find($id);

		if ($staff instanceof Staff)
			return $this->setStaff($staff);

		return $this->setStaff(null);
	}

	/**
	 * Add Student
	 *
	 * @param int $id
	 *
	 * @return VoterDetails
	 */
	public function addStudent($student): VoterDetails
	{
		if (substr($student, 0, 4) !== 'stud')
			return $this->setStudent(null);

		$id = intval(substr($student, 4));

		if (gettype($id) !== 'integer' || empty($id))
			return $this->setStudent(null);

		$student = $this->om->getRepository(Student::class)->find($id);
		if ($student instanceof Student)
			$this->setStudent($student);

		return $this;
	}

	/**
	 * Add Grade
	 *
	 * @param string $grade
	 *
	 * @return VoterDetails
	 */
	public function addGrade($grade): VoterDetails
	{
		if (substr($grade, 0, 4) !== 'grad')
			return $this;

		if ($this->grades->contains($grade))
			return $this;

		$this->grades->add($grade);

		return $this;
	}

	/**
	 * Remove Grade
	 *
	 * @param string $grade
	 *
	 * @return VoterDetails
	 */
	public function removeGrade($grade): VoterDetails
	{
		$this->grades->removeElement($grade);

		return $this;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getGrades(): ArrayCollection
	{
		return $this->grades;
	}

	/**
	 * Get Student
	 *
	 * @return null
	 */
	public function getStudent()
	{
		return $this->student;
	}

	/**
	 * Set Student
	 *
	 * @param Student $student
	 *
	 * @return VoterDetails
	 */
	public function setStudent(Student $student = null): VoterDetails
	{
		$this->student = $student;

		return $this;
	}

	/**
	 * Get Student
	 *
	 * @return null
	 */
	public function getStaff()
	{
		return $this->staff;
	}

	/**
	 * Set Student
	 *
	 * @param Student $student
	 *
	 * @return VoterDetails
	 */
	public function setStaff(Staff $staff = null): VoterDetails
	{
		$this->staff = $staff;

		return $this;
	}

	/**
	 * @param PersonManager $pm
	 * @param User          $user
	 */
	public function userIdentifier(PersonManager $pm, User $user): VoterDetails
	{
		$person = $user->getPerson();

		if ($person instanceof Person)
		{
			if ($pm->isStaff($person))
			{
				$this->setIdentifierType('staff');

				return $this->addStaff('staf' . $person->getStaff()->getId());
			}
			if ($pm->isStudent($person))
			{
				$this->setIdentifierType('student');

				return $this->addStudent('stud' . $person->getStudent()->getId());
			}
		}

		return $this;
	}

	/**
	 * @param $id of PeriodActivity
	 *
	 * @return VoterDetails
	 */
	public function activityIdentifier($id): VoterDetails
	{
		$this->activity = $this->om->getRepository(PeriodActivity::class)->find($id);

		return $this;
	}

	/**
	 * @return PeriodActivity|null
	 */
	public function getActivity()
	{
		return $this->activity;
	}

	/**
	 * @param Activity $activity
	 *
	 * @return VoterDetails
	 */
	public function setActivity(Activity $activity): VoterDetails
	{
		$this->activity = $activity;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getIdentifierType()
	{
		return $this->identifierType;
	}

	/**
	 * @param $identifier
	 *
	 * @return VoterDetails
	 */
	public function setIdentifierType($identifier): VoterDetails
	{
		$this->identifierType = substr($identifier, 0, 4);

		if (!in_array($this->identifierType, ['grad', 'staf', 'stud']))
			$this->identifierType = null;

		return $this;
	}
}
