<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/4/17
 * Time: 11:41 PM
 */

namespace AltORM\Db\ColumnFactory;


use AltORM\Db\Validator;

class AbstractColumn
{

	const COLUMN_TYPE_VARCHAR = 'VARCHAR';
	const COLUMN_TYPE_TEXT = 'TEXT';
	const COLUMN_TYPE_INT = 'INT';
	const COLUMN_TYPE_DECIMAL = 'DECIMAL';
	const COLUMN_TYPE_DATETIME = 'DATETIME';
	const COLUMN_TYPE_TIMESTAMP = 'TIMESTAMP';
	const COLUMN_TYPE_FLOAT = 'FLOAT';

	/** @var  string */
	private $_columnName = '';

	/** @var  string */
	private $_columnType = '';

	/** @var  array */
	private $_columnParams = array();

	/**
	 * AbstractColumn constructor.
	 *
	 * @param $columnName
	 * @param $columnType
	 */
	function __construct($columnName, $columnType, $params = array()) {
		$this->_columnName = $columnName;
		$this->_columnType = $columnType;
		$this->_columnParams = $params;
	}

	/**
	 * @return string
	 */
	public function getColumnName()
	{
		return $this->_columnName;
	}


	/**
	 * @return string
	 */
	public function getColumnType()
	{
		return $this->_columnType;
	}


	/**
	 * @throws \Exception
	 * @return int
	 */
	public function getLength()
	{
		throw new \Exception('You need to init in subclasses');
	}

	/**
	 * @return boolean
	 */
	public function getNullable()
	{
		return $this->getParameters()['nullable'];
	}

	/**
	 * @return mixed
	 */
	public function getDefault()
	{
		return $this->getParameters()['default'];
	}

	/**
	 * @return string
	 */
	public function getColumnTypeLength()
	{
		if($this->getLength() == ''){
			return sprintf("%s", $this->getColumnType());
		}else{
			return sprintf("%s%s", $this->getColumnType(), $this->getLength());

		}
	}


	/**
	 * @return array
	 */
	public function getParameters()
	{
		return $this->_columnParams;
	}

	/**
	 * @return Validator
	 */
	public function getValidator()
	{
		return Validator::validator();
	}



	/**
	 * Represent string with other optional params for column
	 *
	 *
	 * @param array $parameters
	 * @return string
	 */
	protected function getAdditionalSql($parameters = [])
	{
		$nullable = '';

		if(!$parameters['nullable']){
			$nullable = ' NOT NULL ';
		}

		$default = '';
		if(!is_null($parameters['default'])){
			$default = sprintf(' DEFAULT %s', $parameters['default']);
		}

		$unique = '';
		if(!is_null($parameters['unique'])){
			$unique = sprintf(' UNIQUE ');
		}

		$sql = $nullable . $default . $unique;

		return $sql;
	}

	/**
	 * @return bool
	 */
	public function isPrimary()
	{
		$params = $this->getParameters();
		return $params['primary'] === true;
	}

	/**
	 *
	 * Prepare alter column code command for
	 *
	 * @param $parameters array
	 * @return string
	 */
	public function alterTable($parameters = [])
	{

	}

	/**
	 *
	 * Prepare alter column code command for
	 *
	 * @return string
	 */
	public function dropColumn()
	{

	}

	/**
	 * @return string
	 */
	public function getColumnSql()
	{
		return sprintf(
			'%s %s',
			$this->createColumn(),
			$this->getAdditionalSql($this->getParameters())
		);


	}

	/**
	 *
	 * Prepare alter column code command for
	 *
	 * @return string
	 */
	protected function createColumn()
	{

		$columnString = sprintf('`%s` %s',
			                     $this->getColumnName(),
			                     $this->getColumnType()
		                     );

		return $columnString;

	}


}