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

	/** @var bool  */
	protected $_isNew = true;
	/**
	 * AbstractModel constructor.
	 *
	 * @param $name
	 */
	function __construct($name)
	{
		$this->_resource = new ResourceDb($name);
	}

	/**
	 * @return bool
	 */
	public function isNew() {
		return $this->_isNew;
	}

	/**
	 * @param bool $isNew
	 */
	public function setIsNew( $isNew ) {
		$this->_isNew = $isNew;
	}

	/**
	 * we need to store resource of each model:
	 * table, columns, indexes, fk.
	 * Get resource will fetch config values to model
	 *
	 * @return ResourceDb
	 */
	public function getResources()
	{
		return $this->_resource;
	}
}