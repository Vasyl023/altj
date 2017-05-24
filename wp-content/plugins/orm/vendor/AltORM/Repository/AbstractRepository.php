<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/22/17
 * Time: 9:40 PM
 */

namespace AltORM\Repository;


use AltORM\Core\AbstractDbModel;

class AbstractRepository implements RepositoryInterface
{

	/**
	 * @param $query
	 * @return Collection
	 */
	public function loadCollection($query)
	{
	}

	/**
	 * @param $id
	 * @return AbstractDbModel
	 */
	public function get($id)
	{
	}

	/**
	 * @param $id
	 * @return boolean
	 */
	public function delete($id)
	{
	}
}