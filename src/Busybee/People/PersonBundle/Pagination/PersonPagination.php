<?php

namespace Busybee\People\PersonBundle\Pagination;

use Busybee\Core\PaginationBundle\Model\PaginationManager;

class PersonPagination extends PaginationManager
{
	/**
	 * @var string
	 */
	protected $paginationName = 'Person';

	/**
	 * build Query
	 *
	 * @version    28th October 2016
	 * @since      28th October 2016
	 *
	 * @param    boolean $count
	 *
	 * @return    query
	 */
	public function buildQuery($count = false)
	{
		$this->initiateQuery($count);
		if ($count)
			$this
				->setQueryJoin()
				->setSearchWhere();
		else
			$this
				->setQuerySelect()
				->setQueryJoin()
				->setOrderBy()
				->setSearchWhere();

		return $this->getQuery();
	}
}