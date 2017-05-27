<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/6/17
 * Time: 6:16 PM
 */

namespace AltORM\Db\ColumnFactory;


class TextColumn extends AbstractColumn
{

	/**
	 * VarcharColumn constructor.
	 *
	 * @param $columnName
	 * @param $params
	 */
	function __construct( $columnName, $params ) {
		parent::__construct( $columnName, AbstractColumn::COLUMN_TYPE_TEXT, $params );
	}

	/**
	 * @return int
	 */
	public function getLength() {

		return "";
	}


	/**
	 * Creating data
	 *
	 * @param array $parameters
	 *
	 * @return string
	 */
	protected function createColumn( $parameters = array() )
	{
		$columnString = sprintf('`%s` %s',
			                     $this->getColumnName(),
			                     $this->getColumnType()
		                     );

		return $columnString;
	}



}