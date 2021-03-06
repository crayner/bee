<?php
namespace GibbonBundle\Model;

use Busybee\People\PersonBundle\Model\PersonManager;
use Doctrine\Common\Persistence\ObjectManager;

class ImportHouses extends ImportManager
{
	/**
	 * ImportPeople constructor.
	 *
	 * @param ObjectManager $gibbonManager
	 * @param ObjectManager $manager
	 * @param PersonManager $personManager
	 */
	public function __construct(ObjectManager $gibbonManager, ObjectManager $manager, PersonManager $personManager)
	{
		parent::__construct($gibbonManager, $manager, $personManager);

		$sql = "SELECT * FROM `gibbonHouse` ORDER BY `name`";

		$stmt = $this->getGibbonManager()->getConnection()->prepare($sql);
		$stmt->execute();
		$houses = $stmt->fetchAll();

		$list = [];

		foreach ($houses as $house)
		{
			$list[$house['name']]['name']      = $house['name'];
			$list[$house['name']]['shortName'] = $house['nameShort'];
			$list[$house['name']]['logo']      = $house['logo'];
		}

		$this->getPersonManager()->getSm()->set('house.list', $list);
	}
}