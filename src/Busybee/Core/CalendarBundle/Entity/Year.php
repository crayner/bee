<?php

namespace Busybee\Core\CalendarBundle\Entity;

use Busybee\Core\CalendarBundle\Model\Year as YearModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * Year
 */
class Year extends YearModel
{
	/**
	 * @var integer
	 */
	private $id;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $status;

	/**
	 * @var \DateTime
	 */
	private $lastModified;

	/**
	 * @var \DateTime
	 */
	private $createdOn;

	/**
	 * @var \Busybee\Core\SecurityBundle\Entity\User
	 */
	private $createdBy;

	/**
	 * @var \Busybee\Core\SecurityBundle\Entity\User
	 */
	private $modifiedBy;
	/**
	 * @var \DateTime
	 */
	private $firstDay;
	/**
	 * @var \DateTime
	 */
	private $lastDay;

	/**
	 * @var \Doctrine\Common\Collections\Collection
	 */
	private $terms;

	/**
	 * @var boolean
	 */
	private $termsSorted = false;

	/**
	 * @var \Doctrine\Common\Collections\Collection
	 */
	private $specialDays;

	/**
	 * @var boolean
	 */
	private $specialDaysSorted = false;

	/**
	 * @var \Doctrine\Common\Collections\Collection
	 */
	private $calendarGroups;

	/**
	 * @var boolean
	 */
	private $calendarGroupsSorted = false;

	/**
	 * @var string
	 */
	private $downloadCache;

	/**
	 * @var int|null
	 */
	private $importIdentifier;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->specialDays    = new ArrayCollection();
		$this->terms          = new ArrayCollection();
		$this->calendarGroups = new ArrayCollection();
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get status
	 *
	 * @return string
	 */
	public function getStatus()
	{
		return strtolower($this->status);
	}

	/**
	 * Set status
	 *
	 * @param $status
	 *
	 * @return $this
	 */
	public function setStatus($status)
	{
		$this->status = strtolower($status);

		return $this;
	}

	/**
	 * Get lastModified
	 *
	 * @return \DateTime
	 */
	public function getLastModified()
	{
		return $this->lastModified;
	}

	/**
	 * Set lastModified
	 *
	 * @param \DateTime $lastModified
	 *
	 * @return Year
	 */
	public function setLastModified($lastModified)
	{
		$this->lastModified = $lastModified;

		return $this;
	}

	/**
	 * Get createdOn
	 *
	 * @return \DateTime
	 */
	public function getCreatedOn()
	{
		return $this->createdOn;
	}

	/**
	 * Set createdOn
	 *
	 * @param \DateTime $createdOn
	 *
	 * @return Year
	 */
	public function setCreatedOn($createdOn)
	{
		$this->createdOn = $createdOn;

		return $this;
	}

	/**
	 * Get createdBy
	 *
	 * @return \Busybee\Core\SecurityBundle\Entity\User
	 */
	public function getCreatedBy()
	{
		return $this->createdBy;
	}

	/**
	 * Set createdBy
	 *
	 * @param \Busybee\Core\SecurityBundle\Entity\User $createdBy
	 *
	 * @return Year
	 */
	public function setCreatedBy(\Busybee\Core\SecurityBundle\Entity\User $createdBy = null)
	{
		$this->createdBy = $createdBy;

		return $this;
	}

	/**
	 * Get modifiedBy
	 *
	 * @return \Busybee\Core\SecurityBundle\Entity\User
	 */
	public function getModifiedBy()
	{
		return $this->modifiedBy;
	}

	/**
	 * Set modifiedBy
	 *
	 * @param \Busybee\Core\SecurityBundle\Entity\User $modifiedBy
	 *
	 * @return Year
	 */
	public function setModifiedBy(\Busybee\Core\SecurityBundle\Entity\User $modifiedBy = null)
	{
		$this->modifiedBy = $modifiedBy;

		return $this;
	}

	/**
	 * Get lastDay
	 *
	 * @return \DateTime
	 */
	public function getLastDay()
	{
		return $this->lastDay;
	}

	/**
	 * Set lastDay
	 *
	 * @param \DateTime $lastDay
	 *
	 * @return Year
	 */
	public function setLastDay($lastDay)
	{
		$this->lastDay = $lastDay;

		return $this;
	}

	/**
	 * Add term
	 *
	 * @param \Busybee\Core\CalendarBundle\Entity\Term $term
	 *
	 * @return Year
	 */
	public function addTerm(\Busybee\Core\CalendarBundle\Entity\Term $term)
	{
		if ($this->terms->contains($term))
			return $this;

		$term->setYear($this);

		$this->terms->add($term);

		return $this;
	}

	/**
	 * Remove term
	 *
	 * @param \Busybee\Core\CalendarBundle\Entity\Term $term
	 */
	public function removeTerm(\Busybee\Core\CalendarBundle\Entity\Term $term)
	{
		$this->terms->removeElement($term);
	}

	/**
	 * Get terms
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getTerms()
	{
		if (count($this->terms) == 0)
			$this->initialiseTerms();

		if (count($this->terms) == 0 || $this->termsSorted)
			return $this->terms;

		$iterator = $this->terms->getIterator();
		$iterator->uasort(function ($a, $b) {
			return ($a->getFirstDay() < $b->getFirstDay()) ? -1 : 1;
		});

		$this->terms = new ArrayCollection(iterator_to_array($iterator, false));

		$this->termsSorted = true;

		return $this->terms;
	}

	/**
	 * Initialise Terms
	 */
	public function initialiseTerms()
	{
		if ($this->terms instanceof PersistentCollection)
			$this->terms->initialize();
	}

	/**
	 * Add specialDay
	 *
	 * @param \Busybee\Core\CalendarBundle\Entity\SpecialDay $specialDay
	 *
	 * @return Term
	 */
	public function addSpecialDay(\Busybee\Core\CalendarBundle\Entity\SpecialDay $specialDay)
	{
		if (!is_null($specialDay->getName()))
			$this->specialDays[] = $specialDay;

		return $this;
	}

	/**
	 * Remove specialDay
	 *
	 * @param \Busybee\Core\CalendarBundle\Entity\SpecialDay $specialDay
	 */
	public function removeSpecialDay(\Busybee\Core\CalendarBundle\Entity\SpecialDay $specialDay)
	{
		$this->specialDays->removeElement($specialDay);
	}

	/**
	 * Get specialDays
	 *
	 * @return null|\Doctrine\Common\Collections\Collection
	 */
	public function getSpecialDays($renew = false)
	{
		if ($this->specialDays instanceof PersistentCollection)
			$this->specialDays->initialize();

		if (count($this->specialDays) == 0)
			return null;

		if ($this->specialDaysSorted && !$renew)
			return $this->specialDays;

		$iterator = $this->specialDays->getIterator();
		$iterator->uasort(function ($a, $b) {
			return ($a->getDay() < $b->getDay()) ? -1 : 1;
		});
		$this->specialDays       = new ArrayCollection(iterator_to_array($iterator, false));
		$this->specialDaysSorted = true;

		return $this->specialDays;
	}

	/**
	 * Add calendarGroups
	 *
	 * @param \Busybee\Core\CalendarBundle\Entity\CalendarGroup $calendarGroups
	 *
	 * @return Year
	 */
	public function addCalendarGroup(\Busybee\Core\CalendarBundle\Entity\CalendarGroup $calendarGroup)
	{
		if ($this->calendarGroups->contains($calendarGroup))
			return $this;

		$calendarGroup->setYear($this);

		$this->calendarGroups->add($calendarGroup);

		return $this;
	}

	/**
	 * Remove calendarGroup
	 *
	 * @param \Busybee\Core\CalendarBundle\Entity\CalendarGroup $calendarGroup
	 */
	public function removeCalendarGroup(\Busybee\Core\CalendarBundle\Entity\CalendarGroup $calendarGroup)
	{
		$this->calendarGroups->removeElement($calendarGroup);
	}

	/**
	 * Get calendarGroups
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getCalendarGroups()
	{
		if (count($this->calendarGroups) == 0)
		{
			if ($this->calendarGroups instanceof PersistentCollection)
				$this->calendarGroups->initialize();
			$this->calendarGroupsSorted = false;
		}

		if (count($this->calendarGroups) == 0)
			return null;

		if ($this->calendarGroupsSorted)
			return $this->calendarGroups;

		$iterator = $this->calendarGroups->getIterator();
		$iterator->uasort(function ($a, $b) {
			return ($a->getSequence() < $b->getSequence()) ? -1 : 1;
		});

		$this->calendarGroups       = new ArrayCollection(iterator_to_array($iterator, false));
		$this->calendarGroupsSorted = true;

		return $this->calendarGroups;

	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 *
	 * @return Year
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get firstDay
	 *
	 * @return \DateTime
	 */
	public function getFirstDay()
	{
		return $this->firstDay;
	}

	/**
	 * Set firstDay
	 *
	 * @param \DateTime $firstDay
	 *
	 * @return Year
	 */
	public function setFirstDay($firstDay)
	{
		$this->firstDay = $firstDay;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDownloadCache(): ?string
	{
		return $this->downloadCache;
	}

	/**
	 * @param string $downloadCache
	 *
	 * @return Year
	 */
	public function setDownloadCache(string $downloadCache = null): Year
	{

		$this->downloadCache = empty($downloadCache) ? null : $downloadCache;

		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getImportIdentifier(): ?int
	{
		return $this->importIdentifier;
	}

	/**
	 * @param int|null $importIdentifier
	 *
	 * @return Year
	 */
	public function setImportIdentifier($importIdentifier): Year
	{
		$this->importIdentifier = $importIdentifier;

		return $this;
	}

	/**
	 * @param \Doctrine\Common\Collections\Collection $calendarGroups
	 *
	 * @return Year
	 */
	public function setCalendarGroups(\Doctrine\Common\Collections\Collection $calendarGroups = null): Year
	{
		$this->calendarGroups = $calendarGroups;

		return $this;
	}
}
