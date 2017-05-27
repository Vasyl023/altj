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
	 * @param \AltORM\Core\Model\AltObject $obj
	 */
	public function save( \AltORM\Core\Model\AltObject $obj )
	{
		// TODO: Implement save() method.
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