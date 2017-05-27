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

	/**
	 * ResourceDb constructor.
	 *
	 * @param $entityCode
	 */
	function __construct($entityCode)
	{
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
	 *
	 * @param AbstractDbModel $obj
	 *
	 * @return AbstractDbModel
	 */
	public function save( AbstractDbModel $obj )
	{

		$data = $obj->getDbData();
		$this->getPdo()->save($data, $this->getTable());

		return $obj;
	}

}