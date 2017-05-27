<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/22/17
 * Time: 9:40 PM
 */

namespace AltORM\Repository;


use AltORM\Core\AbstractDbModel;
use AltORM\Core\Resource\ResourceDb;

class AbstractRepository implements RepositoryInterface
{
	/**
	 * @var
	 */
	private $_resources;

	protected $_entityId;

	function __construct($name) {

		$this->_entityId = $name;

		$this->loadClass();

	}

	/**
	 * Object factory for classes
	 *
	 * @return AbstractDbModel
	 */
	protected function loadClass()
	{
		$classRepo = get_class($this);

		$classObject = str_replace('Repository', '', $classRepo);

		return new $classObject();

	}

	/**
	 * @return ResourceDb
	 */
	protected function getResources()
	{
		if(!$this->_resources){
			$this->_resources = new ResourceDb($this->_entityId);
		}
		return $this->_resources;
	}



	/**
	 * @param $id
	 * @return AbstractDbModel
	 */
	public function get($id)
	{
		$objData = $this->getResources()->get($id);

		$obj = $this->mapDataToObject($objData);

		return $obj;
	}

	/**
	 * @param $id
	 * @return boolean
	 */
	public function delete($id)
	{

	}

	public function save( \AltORM\Core\Model\AltObject $obj ) {

		$objData = $this->getResources()->save($obj);

		return $obj;
	}

	/**
	 * @param $query
	 * @return array
	 */
	public function load( $query ) {
		// TODO: Implement load() method.
	}

	/**
	 * @param array
	 *
	 * @return AbstractDbModel
	 */
	protected function mapDataToObject($data)
	{
		/** @var  $object */
		$object = $this->loadClass();

		$object->putData($data);

		return $object;
	}

}