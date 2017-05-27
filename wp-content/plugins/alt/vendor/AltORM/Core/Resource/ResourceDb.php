<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/26/17
 * Time: 8:50 PM
 */
namespace AltORM\Core\Resource;

use AltORM\AltORM;
use AltORM\Core\AbstractDbModel;
use AltORM\Core\Annotation\Parser;
use AltORM\Core\Helper\Core;
use AltORM\Core\Model\AltObject;
use AltORM\Db\Pdo;

/**
 * Class ResourceDb
 * Communication to pdo
 * @package AltORM\Core\Resource
 */
class ResourceDb extends AltObject
{

	/** @var string  */
	protected $entityCode;

	/** @var array  */
	protected $configs = array();

	/** @var Core */
	protected $helper;

	/**
	 * ResourceDb constructor.
	 *
	 * @param $entityCode
	 */
	function __construct($entityCode)
	{
		$this->helper = new Core();
		$this->entityCode = $entityCode;
	}

	/**
	 * @return Pdo
	 */
	protected function getPdo()
	{
		return Pdo::getInstance();
	}
	/**
	 * @return mixed
	 */
	public function getTable()
	{
		return $this->getConfig()['table'];
	}

	/**
	 * @return mixed
	 */
	public function getColumns()
	{
		return $this->getConfig()['columns'];
	}

	public function getColumnsName()
	{
		$result = [];

		foreach ( $this->getColumns() as $column ) {
			$result[] = $column[Parser::PARSER_COLUMN_NAME];
		}

		return $result;
	}

	/**
	 *
	 * @return array
	 */
	public function getConfig()
	{
		if(!$this->configs) {
			$this->configs = AltORM::getConfig()->getConfigs( $this->entityCode );
		}

		return $this->configs;
	}

	/**
	 * @param $id
	 *
	 * @return array|null|object
	 */
	public function get($id)
	{

		$result = $this->getPdo()->selectOne($id, $this->getColumns(), $this->getTable());

		return $result;

	}

	/**
	 * Save objects
	 *
	 * @param AbstractDbModel $obj
	 *
	 * @return AbstractDbModel
	 * @throws \Exception
	 */
	public function save( AbstractDbModel $obj )
	{
		$columns = $this->getColumnsName();

		$data = [];

		foreach ( $columns as $column ) {

			$getter = $this->helper->getGetterMethodName($column);

			if( property_exists($obj, $column)
			   && method_exists($obj, $getter)){
				$data[$column] = $obj->{$getter}();
			}else{
				throw new \Exception('There is something wrong with your getters or properties');
			}

		}

		// remove identifier for new
		if($obj->isNew()){
			$col = $this->getPdo()->findPrimaryColumn($this->getColumns());
			unset($data[$col]);
		}

		$this->getPdo()->save($data, $this->getTable());

		return $obj;
	}

	/**
	 *
	 * @param AbstractDbModel $obj
	 *
	 * @throws \Exception
	 */
	public function delete($obj)
	{
		$col = $this->getPdo()->findPrimaryColumn($this->getColumns());

		$getter = $this->helper->getGetterMethodName($col);

		if(!is_null($col)
			&& property_exists($obj, $col)
			&& method_exists($obj, $getter)){

			// get unique value
			$id = $obj->{$getter}();

			$this->getPdo()->deleteUnique($id, $this->getColumns(), $this->getTable());

		}else{
			throw new \Exception('There is something wrong with your getters or properties');
		}

	}
}