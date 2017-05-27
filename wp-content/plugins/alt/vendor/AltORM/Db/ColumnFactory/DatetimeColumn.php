<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/6/17
 * Time: 2:27 PM
 */

namespace AltORM\Db\ColumnFactory;


class DatetimeColumn extends AbstractColumn
{

	/**
	 *
	 * @param $columnName
	 * @param $params
	 */
	function __construct( $columnName, $params ) {
		parent::__construct( $columnName, AbstractColumn::COLUMN_TYPE_DATETIME, $params );
	}


	public function getLength() {
		return '';
	}
}