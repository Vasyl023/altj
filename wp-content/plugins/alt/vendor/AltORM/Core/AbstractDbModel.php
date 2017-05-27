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
	function _construct($name)
	{
		$this->_resource = new ResourceDb($name);
	}

	/**
	 * Get data for saving
	 * @return array
	 * @throws \Exception
	 */
	public function getDbData()
	{
		$names = $this->getResources()->getColumnsName();
		$result = [];
		foreach ( $names as $property ) {
			if(property_exists($this, $property))
			{
				$result[$property] = $this->{$property};
			}else{
				throw new \Exception('You have not migrated DB');
			}
		}

		return $result;

	}

	/**
	 *
	 *
	 * @param array $values
	 *
	 * @return $this
	 */
	public function putData($values = [])
	{
		foreach ( $values as $property => $value ) {
			if(property_exists($this, $property))
			{
				$this->{$property} = $value;
			}else{
				$this->setData($property, $value);
			}
		}

		return $this;
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