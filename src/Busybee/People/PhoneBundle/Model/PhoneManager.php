<?php

namespace Busybee\People\PhoneBundle\Model;

use Busybee\People\PhoneBundle\Entity\Phone;
use Busybee\People\PhoneBundle\Repository\PhoneRepository;
use Symfony\Component\Translation\TranslatorInterface as Translator;
use Busybee\Core\SystemBundle\Setting\SettingManager;

/**
 * Phone Manager
 *
 * @version    8th November 2016
 * @since      28th October 2016
 * @author     Craig Rayner
 */
class PhoneManager
{
	/**
	 * @var    Translator
	 */
	private $trans;

	/**
	 * @var SettingManager
	 */
	private $settingManager;

	/**
	 * @var    PhoneRepository
	 */
	private $phoneRepository;

	/**
	 * Constructor
	 *
	 * @version    8th November 2016
	 * @since      28th October 2016
	 *
	 * @param    Translator
	 */
	public function __construct(Translator $trans, SettingManager $settingManager, PhoneRepository $phoneRepository)
	{
		$this->trans           = $trans;
		$this->settingManager  = $settingManager;
		$this->phoneRepository = $phoneRepository;
	}

	/**
	 * Format Phone
	 *
	 * @version    8th November 2016
	 * @since      8th November 2016
	 *
	 * @param    \Busybee\People\AddressBundle\Entity\Address $phone
	 *
	 * @return    html string
	 */
	public function formatPhone($phone)
	{
		if ($phone instanceof Phone)
			$data = array(
				'phoneType'   => $phone->getPhoneType(),
				'phoneNumber' => $phone->getPhoneNumber(),
				'countryCode' => $phone->getCountryCode());
		else
			$data = array(
				'phoneType'   => null,
				'phoneNumber' => null,
				'countryCode' => null);

		return $this->settingManager->get('phone.format', null, $data);
	}
}