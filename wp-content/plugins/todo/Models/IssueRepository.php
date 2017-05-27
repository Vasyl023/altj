<?php

namespace Todo\Models;

/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/26/17
 * Time: 12:00 AM
 */
class IssueRepository extends \AltORM\Repository\AbstractRepository
	implements \AltORM\Repository\RepositoryInterface
{

	/**
	 * UserRepository constructor.
	 */
	function __construct()
	{
		parent::__construct('todo/Issue');
	}

}