<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/26/17
 * Time: 12:04 AM
 */

namespace AltORM\Core;

use AltORM\Core\Resource\ResourceDb;
use AltORM\Core\Model\AltObject;

abstract class AbstractDbModel extends AltObject {


	/** @var  ResourceDb */
	private $_resource;

	/**
	 * AbstractModel constructor.
	 *
	 * @param $name
	 */
	function _construct($name) {
		$this->_resource = new ResourceDb($name);
	}

	/**
	 *
	 */
	public function save()
	{

	}

	/**
	 *
	 */
	public function remove()
	{

	}


	/**
	 * we need to store resource of each model:
	 * table, columns, indexes, fk.
	 * Get resource will fetch config values to model
	 *
	 * @return ResourceDb
	 */
	protected function getResources()
	{
		return $this->getResources();
	}
}