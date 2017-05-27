<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/6/17
 * Time: 6:18 PM
 */

namespace AltORM\Db\ColumnFactory;


class FloatColumn extends AbstractColumn
{

	/**
	 * VarcharColumn constructor.
	 *
	 * @param $columnName
	 * @param $params
	 */
	function __construct( $columnName, $params ) {
		parent::__construct( $columnName, AbstractColumn::COLUMN_TYPE_DECIMAL, $params );
	}

	/**
	 * @return string
	 */
	public function getLength() {
		return sprintf("(11,%s)", $this->getParameters()['length']);
	}

	/**
	 *
	 * @return string
	 */
	protected function createColumn()
	{
		$length = 2;

		if(isset($parameters['length'])
		   && $parameters['length'] > 1
		   && 11 >= $parameters['length']){
			$length = $parameters['length'];
		}

		$columnString = sprintf('`%s` %s (11,%d)',$this->getColumnName(), $this->getColumnType(), $length);

		return $columnString;
	}

}