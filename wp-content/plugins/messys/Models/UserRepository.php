<?php

namespace MesSys\Models;

/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/26/17
 * Time: 12:00 AM
 */
class UserRepository extends \AltORM\Repository\AbstractRepository
	implements \AltORM\Repository\RepositoryInterface
{

	/**
	 * UserRepository constructor.
	 */
	function __construct()
	{
		parent::__construct('messys/User');
	}

	/**
	 * @param $query
	 *
	 * @return array|void
	 */
	public function load( $query )
	{
		// TODO: Implement load() method.
	}
}