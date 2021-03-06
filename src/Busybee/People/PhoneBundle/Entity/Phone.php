<?php

namespace Busybee\People\PhoneBundle\Entity;

use Busybee\People\PhoneBundle\Model\PhoneModel;

/**
 * Phone
 */
class Phone extends PhoneModel
{
	/**
	 * @var integer
	 */
	private $id;

	/**
	 * @var string
	 */
	private $phoneType;

	/**
	 * @var string
	 */
	private $phoneNumber;

	/**
	 * @var string
	 */
	private $countryCode;

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
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get phoneType
	 *
	 * @return string
	 */
	public function getPhoneType()
	{
		return $this->phoneType;
	}

	/**
	 * Set phoneType
	 *
	 * @param string $phoneType
	 *
	 * @return Phone
	 */
	public function setPhoneType($phoneType)
	{
		$this->phoneType = $phoneType;

		return $this;
	}

	/**
	 * Get phoneNumber
	 *
	 * @return string
	 */
	public function getPhoneNumber()
	{
		return $this->phoneNumber;
	}

	/**
	 * Set phoneNumber
	 *
	 * @param string $phoneNumber
	 *
	 * @return Phone
	 */
	public function setPhoneNumber($phoneNumber)
	{
		$this->phoneNumber = $phoneNumber;

		return $this;
	}

	/**
	 * Get countryCode
	 *
	 * @return string
	 */
	public function getCountryCode()
	{
		return $this->countryCode;
	}

	/**
	 * Set countryCode
	 *
	 * @param string $countryCode
	 *
	 * @return Phone
	 */
	public function setCountryCode($countryCode)
	{
		$this->countryCode = $countryCode;

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
	 * @return Phone
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
	 * @return Phone
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
	 * @return Phone
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
	 * @return Phone
	 */
	public function setModifiedBy(\Busybee\Core\SecurityBundle\Entity\User $modifiedBy = null)
	{
		$this->modifiedBy = $modifiedBy;

		return $this;
	}
}
