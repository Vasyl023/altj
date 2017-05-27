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

}