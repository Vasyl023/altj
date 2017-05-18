<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/6/17
 * Time: 3:17 PM
 */

namespace AltORM\Db;


use AltORM\Db\Adapter\Mysql;
use AltORM\Db\ColumnFactory\AbstractColumn;

/**
 * Class Pdo
 * Here we manage relation to wpdb, Adapter pattern
 * @package AltORM\Db
 */
class Pdo {


	/** @var  Adapter */
	protected $_adapter;



	/**
	 * Pdo constructor.
	 */
	public function __construct() {
		$this->_adapter = new Mysql();
	}


	/**
	 *
	 * @return Adapter
	 */
	public function getAdapter()
	{

		if(!$this->_adapter){
			$this->_adapter = new Mysql();
		}

		return $this->_adapter;
	}


	/**
	 * @return \wpdb
	 */
	public function getWpdb(){
		global $wpdb;
		return $wpdb;
	}


	/**
	 * @param $columns
	 * @return AbstractColumn[]
	 */
	protected function prepareColumns($columns)
	{
		// prepare columns with factory
		$columnsNew = [];

		$factoryDb = new FactoryDb();

		foreach ( $columns as $column ) {
			$columnName = $column['name'];
			$columnType = $column['db_type'];
			$params = $column['params'];
			$columnsNew[] = $factoryDb->getTableColumn($columnName, $columnType, $params);
		}

		return $columnsNew;
	}


	/**
	 *
	 * We prepare here data and create table through database adapter
	 *
	 * @param $name
	 * @param $columns
	 *
	 * $colunss = [
	 *      'name' = columnname,
	 *      'db_type' = type
	 * ]
	 *
	 * @throws \Exception
	 */
	public function createTable($name, $columns)
	{

		if($this->getWpdb()->query(
			$this->getAdapter()->checkIfTableExist($name)
		) ){
			$this->startColumnMigration($name, $columns);
			// Skip woking with table for now
			return;
		}

		$cols = $this->prepareColumns($columns);

		$sql = $this->getAdapter()->createTable($name, $cols);

		$result = $this->getWpdb()->query($sql);


		if(!$result)
		{
			throw new \Exception(sprintf('Something went wrong with Table %s creation. Error: %s', $name, $this->getWpdb()->last_error));
		}

	}

	/**
	 * Migration tasks for table
	 *
	 * @param $tableName
	 * @param array $columns
	 */
	public function startColumnMigration($tableName, $columns = array())
	{

		$sql = $this->getAdapter()->getTableColumns($tableName);
		$tableColumns = $this->getWpdb()->get_results($sql,ARRAY_A);

		// prepare columns
		$configColumns = $this->prepareColumns($columns);

		foreach ( $tableColumns as $tableColumn ) {

			foreach ($configColumns as $configColumn) {
				if(!$this->isCompareColumns($tableColumn, $configColumn))
				{

				}
			}


		}
	}

	/**
	 *
	 *
	 * @param $col1 array
	 * @param $col2 AbstractColumn
	 *
	 * @return boolean
	 */
	public function isCompareColumns($col1, $col2)
	{


		if(strtoupper($col1['Type']) != strtoupper($col2->getColumnTypeLength())
		|| ($col1['Null'] == 'YES') != $col2->getNullable()
		|| ($col1['Default'] == 'YES') != $col2->getDefault()){
			return false;
		}
		return true;
	}

}