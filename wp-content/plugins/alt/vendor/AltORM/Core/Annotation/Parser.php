<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/29/17
 * Time: 2:32 PM
 */

namespace AltORM\Core\Annotation;

use AltORM\Core\Annotations\Column;
use AltORM\Core\Annotations\Table;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Parser implements AnnotationInterface
{

	const PARSER_COLUMN_NAME = 'name';
	const PARSER_COLUMN_TYPE = 'db_type';
	const PARSER_COLUMN_LENGTH = 'length';
	const PARSER_COLUMN_NULLABLE = 'nullable';
	const PARSER_COLUMN_DEFAULT = 'default';
	const PARSER_COLUMN_PRIMARY = 'primary';
	const PARSER_COLUMN_UNIQUE = 'unique';


	public $_reader = null;

	function __construct() {
		$this->getAnnotationReader();
	}


	/**
	 * @param $classFile
	 * @param $class
	 * @param array $params
	 *
	 * @return array
	 */
	public function parseClass($classFile, $class, $params = array())
	{

		require_once $classFile;

		// initiate annotation, better to move to some other place
		$table = new Table();
		$table = new Column();
		// end init

		$reflClass = new \ReflectionClass($class);

		$alias = isset($params['alias']) ? $params['alias'] : '';

		$result = array_merge($this->getClassData($reflClass, $alias), $this->getConstantsData($reflClass));


		return $result;
	}

	/**
	 * Get general class data
	 *
	 * @param $reflClass \ReflectionClass
	 * @param string $alias
	 *
	 * @return array
	 */
	protected function getClassData($reflClass, $alias = '')
	{

		$classAnnotations = $this->getAnnotationReader()->getClassAnnotations($reflClass);

		return array( 'table' => $alias . $classAnnotations[0]->name);

	}


	/**
	 * Get parameters with anotation
	 *
	 * @param $reflClass \ReflectionClass
	 * @return array
	 */
	protected function getConstantsData($reflClass)
	{
		$props = $reflClass->getProperties();
		$result = array();
		foreach ( $props as $prop ) {
			$array = $this->getAnnotationReader()->getPropertyAnnotations($prop);
			$obj = $array[0];

			$result[] = array(
				self::PARSER_COLUMN_NAME => $prop->getName(),
				self::PARSER_COLUMN_TYPE => $obj->name,
				'params' => array(
						self::PARSER_COLUMN_PRIMARY => $obj->primary,
						self::PARSER_COLUMN_UNIQUE => $obj->unique,
						self::PARSER_COLUMN_LENGTH => $obj->length,
						self::PARSER_COLUMN_NULLABLE => $obj->nullable,
						self::PARSER_COLUMN_DEFAULT => $obj->default
					)
			);
		}

		return array('columns' => $result);
	}

	protected function getAnnotationReader()
	{
		if (is_null($this->_reader)){
			$this->_reader = new AnnotationReader();
		}
		return $this->_reader;
	}



}