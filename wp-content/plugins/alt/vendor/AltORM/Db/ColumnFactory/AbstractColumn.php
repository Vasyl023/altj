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
	public function isNullable()
	{
		return $this->getParameters()['nullable'] === true;
	}

	/**
	 * @return boolean
	 */
	public function isUnique()
	{
		return $this->getParameters()['unique'] === true;
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
	 * @return string
	 */
	protected function getAdditionalSql()
	{

		$parts = [];

		if($this->isNullable()){
			$parts[] = 'NOT NULL';
		}

		if(!is_null($this->getDefault())){
			$default = $this->getDefault();
			if(is_int($this->getDefault())){
				$parts[] = sprintf('DEFAULT %d', $default);
			}else{
				$parts[] = sprintf("DEFAULT '%s'", $default);
			}

		}

		if($this->isUnique()){
			$parts[] = sprintf('UNIQUE');
		}

		if($this->isPrimary()){
			$parts[] = 'AUTO_INCREMENT';
		}

		return implode(' ', $parts);
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
	 * @return string
	 */
	public function alterTable()
	{
		return $this->getColumnSql();
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
			$this->getAdditionalSql()
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