<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/6/17
 * Time: 3:17 PM
 */

namespace AltORM\Db;


use AltORM\Core\Annotation\Parser;
use AltORM\Db\Adapter\Mysql;
use AltORM\Db\ColumnFactory\AbstractColumn;

/**
 * Class Pdo
 * Here we manage relation to wpdb, Adapter pattern for mysql
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



	static public function getInstance()
	{
		static $ints = null;
		if(is_null($ints)){
			$ints = new Pdo();
		}
		return $ints;

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
	 * Prepare datas
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
			// Skip working with table for now
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
	protected function startColumnMigration($tableName, $columns = array())
	{
		$sql = $this->getAdapter()->getTableColumns($tableName);
		// return data from existing db
		$tableColumns = $this->getWpdb()->get_results($sql,ARRAY_A);

		// prepare columns
		$configColumns = $this->prepareColumns($columns);

		$existing_columns = $tableColumns;

		foreach ($configColumns as $configColumn) {

			// run comparing columns, and male change
			$key = $this->findTableColumn($configColumn->getColumnName(), $tableColumns);

			if(is_null($key)){
				$sql = $this->getAdapter()
				            ->alterAddColumnToTable(
				            	$tableName,
								$configColumn->alterTable()
							);

				$this->getWpdb()->query($sql);
			}elseif(!$this->isEqualColumns($tableColumns[$key], $configColumn))
			{
				$sql = $this->getAdapter()
				            ->alterTable(
				                $tableName,
								$tableColumns[$key]['Field'],
								$configColumn->alterTable()
				);

				$this->getWpdb()->query($sql);
			}

			if($key >= 0){
				unset($existing_columns[$key]);
			}
		}

		// drop all other columns
		foreach ( $existing_columns as $existing_column ) {
			$this->getWpdb()->query(
					$this->getAdapter()
						->dropTableColumn($tableName, $existing_column['Field'])
			);
		}

	}

	/**
	 * @param $name
	 * @param $array
	 *
	 * @return int| null
	 */
	protected function findTableColumn($name, $array)
	{
		foreach ( $array as $key => $item ) {
			if($item['Field'] == $name){
				return $key;
			}
		}
		return null;
	}

	/**
	 *Compare value from config and database
	 *
	 * @param $col1 array
	 * @param $col2 AbstractColumn
	 *
	 * @return boolean
	 */
	protected function isEqualColumns($col1, $col2)
	{

		if(strtoupper($col1['Type']) != strtoupper($col2->getColumnTypeLength())
		|| ($col1['Null'] == 'YES') != $col2->isNullable()
		|| $col1['Default'] != $col2->getDefault()){
			return false;
		}

		return true;
	}

	/**
	 * @param $id
	 * @param $columns
	 * @param $table
	 *
	 * @return array|null|object
	 */
	public function selectOne($id, $columns, $table)
	{

		$col = $this->findPrimaryColumn($columns);

		if(!is_null($col)){
			$result = $this->getWpdb()->get_row(
				$this->getAdapter()->select([
					$col => $id
				], $table), ARRAY_A);
			return $result ? $result : [];
		}

		return [];
	}

	/**
	 * @param $columns
	 *
	 * @return null|string
	 */
	protected function findPrimaryColumn($columns)
	{
		$cols = $this->prepareColumns($columns);

		foreach ( $cols as $column ) {
			if($column->isPrimary()){
				return $column->getColumnName();
			}
		}

		return null;
	}

	/**
	 *
	 * Save all data to db
	 *
	 * @param array $data
	 * @param $table
	 *
	 * @return $this
	 * @throws \Exception
	 */
	public function save($data = [], $table)
	{
		if(is_array($data))
		{
			$result = $this->getWpdb()->replace(
				$table,
				$data
			);

			if($result === false)
			{
				throw new \Exception('Something went wrong!' . PHP_EOL . $this->getWpdb()->last_error);
			}
		}
		return $this;
	}
}