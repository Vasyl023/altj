<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/4/17
 * Time: 11:07 PM
 */

namespace AltORM\Core\Model;

class AltObject
{

	/** @var array  */
	private $_data = array();


	function __get( $name ) {
		if(isset($this->_data[$name]))
			return $this->_data[$name];
	}


	function __set( $name, $value ) {

		$this->_data[$name] = $value;

	}


}