<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/29/17
 * Time: 5:01 PM
 */

namespace AltORM\Core\Annotation;

interface AnnotationInterface
{
	/**
	 * @param $classFile
	 * @param $class
	 * @param array $params
	 *
	 * @return array
	 */
	public function parseClass($classFile, $class, $params = array());
}