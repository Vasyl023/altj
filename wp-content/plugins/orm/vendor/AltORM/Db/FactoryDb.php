<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/4/17
 * Time: 11:37 PM
 */

namespace AltORM\Db;

use AltORM\Db\ColumnFactory\AbstractColumn;
use AltORM\Db\ColumnFactory\DatetimeColumn;
use AltORM\Db\ColumnFactory\FloatColumn;
use AltORM\Db\ColumnFactory\NumberColumn;
use AltORM\Db\ColumnFactory\TextColumn;
use AltORM\Db\ColumnFactory\VarcharColumn;

/**
 * Class FactoryDb
 * Here we have a factory method pattern implementation
 *
 * @package AltORM\Db
 */
class FactoryDb
{


	function __construct() {
	}


	/**
	 * Factory method
	 *
	 * @param $name
	 * @param $type
	 * @param array $params
	 *
	 * @return AbstractColumn
	 */
	public function getTableColumn($name, $type, $params = [] )
	{

		$column = null;

		switch (strtoupper($type)){
			case AbstractColumn::COLUMN_TYPE_VARCHAR:
				$column = new VarcharColumn($name, $params);

				break;
			case AbstractColumn::COLUMN_TYPE_TEXT:
				$column = new TextColumn($name, $params);

				break;
			case AbstractColumn::COLUMN_TYPE_INT:
				$column = new NumberColumn($name, $params);

				break;
			case AbstractColumn::COLUMN_TYPE_FLOAT:
				$column = new FloatColumn($name, $params);

				break;
			case AbstractColumn::COLUMN_TYPE_DATETIME:
				$column = new DatetimeColumn($name, $params);
				break;
			default:
				$column = new VarcharColumn($name, $params);
				break;
		}

		return $column;
	}

}