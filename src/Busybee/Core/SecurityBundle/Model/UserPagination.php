<?php

namespace Busybee\Core\SecurityBundle\Model;

use Busybee\Core\PaginationBundle\Model\PaginationManager;

class UserPagination extends PaginationManager
{
	protected $paginationName = 'User';

	/**
	 * build Query
	 *
	 * @version    25th October 2016
	 * @since      25th October 2016
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