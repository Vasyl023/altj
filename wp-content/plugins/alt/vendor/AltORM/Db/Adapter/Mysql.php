<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/10/17
 * Time: 11:55 PM
 */

namespace AltORM\Db\Adapter;

use AltORM\Db\Adapter;
use AltORM\Db\ColumnFactory\AbstractColumn;

class Mysql implements Adapter
{


	/**
	 *
	 * Escape from characters
	 *
	 * @param $string
	 *
	 * @return array|string
	 */
	public function escape($string)
	{
		return esc_sql($string);
	}

	/**
	 * {@inheritdoc}
	 */
	public function createTable( $name, $columns, $indexes = array() )
	{

		$sql_string = sprintf("CREATE TABLE %s ", $this->escape($name));

		$columns_sql = [];

		$primary = null;

		foreach ( $columns as $column ) {
			/** @var AbstractColumn $column */
			$columns_sql[] = $column->getColumnSql();

			if($column->isPrimary()){
				$primary = $column->getColumnName();
			}
		}

		if(!is_null($primary)){
			$columns_sql[] = sprintf("PRIMARY KEY (`%s`)", $primary);
		}

		$sql_string = sprintf("%s (%s);", $sql_string, implode( ",\n", $columns_sql));

		return $sql_string;
	}

	/**
	 * @param $name
	 * @return string
	 */
	public function checkIfTableExist($name)
	{
		return sprintf("SHOW TABLES LIKE '%s';", $name);
	}

	/**
	 * Sql statement
	 * @return string
	 */
	public function getTableColumns($tableName)
	{

		return sprintf('Show columns from %s;', $tableName);

	}

	/**
	 *
	 * @param $table string
	 * @param $columnSql string
	 *
	 * @return string
	 */
	public function alterTable($table, $columnName, $columnSql)
	{
		return sprintf('ALTER TABLE `%s` CHANGE COLUMN `%s` %s', $table, $columnName, $columnSql);
	}

	/**
	 * @param $table
	 * @param $columnSql
	 *
	 * @return string
	 */
	public function alterAddColumnToTable($table,  $columnSql)
	{

		return sprintf('ALTER TABLE `%s` ADD COLUMN `%s`', $table, $columnSql);
	}

	/**
	 * @param $table
	 * @param $columnName
	 *
	 * @return string
	 */
	public function dropTableColumn($table, $columnName){
		return sprintf('ALTER TABLE `%s` DROP COLUMN `%s`', $table, $columnName);
	}


	/**
	 * @param $parameters
	 * @param $table
	 * @param string $cols
	 *
	 * @return string
	 */
	public function select($parameters, $table, $cols = "*")
	{
		return "SELECT $cols FROM `$table` WHERE " . $this->bindParameters($parameters, $table);
	}




	/**
	 * @param $parameters
	 *
	 * @param $table
	 *
	 * @return string
	 */
	protected function bindParameters($parameters, $table)
	{
		$result = [];
		foreach ( $parameters as $key => $value ) {

			if(!is_int($value)){
				$tmp = $this->escape(sprintf("`$table`.`$key` = '%s'", $value));
			}else{
				$tmp = $this->escape(sprintf("`$table`.`$key` = %d", $value));
			}

			$result[] = $tmp;

		}

		$sql = implode(' AND ', $result);

		return $sql;
	}


	/**
	 * Parameters, as in example
	 *
	 * @param $table
	 * @param $parameters
	 *
	 * @param string $cols
	 *
	 * @return string
	 */
	public function selectWithAttributes($table, $parameters, $cols = '*')
	{
		return "SELECT $cols FROM `$table` WHERE " . $this->bindLoadParameters($parameters, $table);
	}

	/**
	 * @param $parameters
	 *
	 * @param $table
	 *
	 * @return string
	 */
	protected function bindLoadParameters($parameters, $table)
	{
		$result = [];

		$parametersSQL = $this->getOperationMapper();

		foreach ( $parameters as $key => $value ) {

			$operation = $parametersSQL[$key];

			$concatanator = isset($value['concat']) ? $value['concat'] : 'AND';
			$column = $value['column'];
			$value = $value['value'];

			if(!is_int($value)){
				if($operation == 'in'){
					$tmp = $this->escape(sprintf("`$table`.`%s` $operation (%s)", $column, $value));
				}else{
					$tmp = $this->escape(sprintf("`$table`.`%s` $operation '%s'", $column, $value));
				}

			}else{
				$tmp = $this->escape(sprintf("`$table`.`%s` $operation %d", $column,  $value));
			}

			$result[$concatanator][] = $tmp;

		}

		$sqls = [];
		if(count($result['AND']) > 0){
			$sqls[] = implode(' AND ', $result['AND']);
		}

		if(count($result['OR']) > 0){
			$sqls[] = implode(' OR ', $result['OR']);
		}
//		var_dump($result);

		$sql = implode(' AND ', $sqls);
		return $sql;
	}



	public function getOperationMapper()
	{
		return [
			'eq'    => '=',
			'neq'   => '!=',
			'like'  => 'LIKE',
			'in'    => 'IN'
		];
	}
}