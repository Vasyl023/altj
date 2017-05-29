<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/10/17
 * Time: 11:54 PM
 */

namespace AltORM\Db;

interface Adapter
{
	/**
	 *
	 *
	 * @param $name
	 * @param $columns
	 * @param array $indexes
	 *
	 * @return string
	 */
	public function createTable($name, $columns, $indexes = array());


	/**
	 * @param $name
	 *
	 * @return string
	 */
	public function checkIfTableExist($name);


	/**
	 * @param $tableName
	 *
	 * @return string
	 */
	public function getTableColumns($tableName);

	/**
	 * @param $parameters
	 * @param $table
	 * @param string $cols
	 *
	 * @return mixed
	 */
	public function select($parameters, $table, $cols = "*");

	/**
	 * @param $table
	 * @param $columnName
	 * @param $columnSql
	 *
	 * @return mixed
	 */
	public function alterTable($table, $columnName, $columnSql);

	/**
	 * @param $table
	 * @param $columnName
	 *
	 * @return mixed
	 */
	public function dropTableColumn($table, $columnName);

	/**
	 * @param $table
	 * @param $columnSql
	 *
	 * @return mixed
	 */
	public function alterAddColumnToTable($table,  $columnSql);

	/**
	 * @param $table
	 * @param $parameters
	 * @param string $cols
	 *
	 * @return mixed
	 */
	public function selectWithAttributes($table, $parameters, $cols = '*');

}