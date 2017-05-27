<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/6/17
 * Time: 12:42 PM
 */

namespace AltORM\Db\ColumnFactory;

/**
 * Class VarcharColumn
 * @package AltORM\Db\ColumnFactory
 */
class VarcharColumn extends AbstractColumn
{
	/**
	 * VarcharColumn constructor.
	 *
	 * @param $columnName
	 * @param $params
	 */
	function __construct( $columnName, $params ) {
		parent::__construct( $columnName, AbstractColumn::COLUMN_TYPE_VARCHAR, $params );
	}

	/**
	 * @return int
	 */
	public function getLength() {
		return (int)isset($this->getParameters()['length']) > 0 ? $this->getParameters()['length'] : 255;
	}

	/**
	 * @return string
	 */
	public function getColumnTypeLength()
	{
		return sprintf("%s(%d)", $this->getColumnType(), $this->getLength());
	}

	/**
	 * Creating data
	 *
	 * @return string
	 */
	protected function createColumn()
	{
		$length = (int)isset($parameters['length']) ? $parameters['length'] : 255;

		$columnString = sprintf('`%s` %s(%d)',
			                     $this->getColumnName(),
			                     $this->getColumnType(),
			                     $length);

		return $columnString;
	}



}