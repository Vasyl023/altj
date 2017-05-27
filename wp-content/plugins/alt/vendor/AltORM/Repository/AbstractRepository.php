<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/22/17
 * Time: 9:40 PM
 */

namespace AltORM\Repository;


use AltORM\Core\AbstractDbModel;
use AltORM\Core\Helper\Core;
use AltORM\Core\Resource\ResourceDb;

class AbstractRepository implements RepositoryInterface
{
	/**
	 * @var ResourceDb
	 */
	private $_resources;

	/**
	 * @var string
	 */
	protected $_entityId;

	function __construct($name) {

		$this->_entityId = $name;

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
	 *
	 * @return AbstractDbModel
	 */
	public function get($id)
	{
		$objData = $this->getResources()->get($id);

		$obj = $this->mapDataToObject($objData);

		$obj->setIsNew(count($objData) == 0);

		return $obj;
	}

	/**
	 * @param AbstractDbModel $object
	 *
	 * @return void
	 */
	public function delete(AbstractDbModel $object)
	{
		$this->getResources()->delete($object);

	}

	/**
	 * Save all data
	 * @param AbstractDbModel $obj
	 *
	 * @return AbstractDbModel
	 */
	public function save( AbstractDbModel $obj ) {

		$objData = $this->getResources()->save($obj);

		return $objData;
	}

	/**
	 * @param $query
	 * @return array
	 */
	public function load( $query ) {
		// TODO: Implement load() method.
	}


	/**
	 * It`s dataBase mapping
	 *
	 * @param $data array
	 *
	 * @return AbstractDbModel
	 * @throws \Exception
	 *
	 */
	protected function mapDataToObject($data)
	{
		/** @var  $object */
		$object = $this->loadClass();

		$helper = new Core();

		foreach ( $data as $key => $value ) {
			$setter = $helper->getSetterMethodName($key);

			if( property_exists($object, $key)
			    && method_exists($object, $setter)){
				$object->{$setter}($value);
			}else{
				print_r($key);
				throw new \Exception('There is something wrong with your setters or properties');
			}
		}

		return $object;
	}

}