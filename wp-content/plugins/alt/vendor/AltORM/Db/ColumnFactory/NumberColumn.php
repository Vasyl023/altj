<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/6/17
 * Time: 2:26 PM
 */

namespace AltORM\Db\ColumnFactory;


class NumberColumn extends AbstractColumn
{
	/**
	 *
	 * @param $params
	 */
	function __construct( $columnName, $params ) {

		parent::__construct( $columnName, AbstractColumn::COLUMN_TYPE_INT, $params );
	}

	/**
	 * @return int
	 */
	public function getLength() {

		$length = 11;

		if(isset($this->getParameters()['length'])
		   && $this->getParameters()['length'] > 1
		   && 11 <= $this->getParameters()['length'])
			$length = $this->getParameters()['length'];

		return sprintf("(%s)", $length);
	}

	/**
	 * @return string
	 */
	protected function createColumn()
	{
		$length = 11;

		if(isset($parameters['length'])
		   && $parameters['length'] > 1
		   && 11 >= $parameters['length'])
		$length = (int)$parameters['length'];

		return sprintf('`%s` %s(%d)',
			                     $this->getColumnName(),
			                     $this->getColumnType(),
			                     $length);

	}
}