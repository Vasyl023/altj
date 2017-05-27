<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/4/17
 * Time: 11:07 PM
 */

namespace AltORM\Core\Model;

/**
 * Class AltObject
 * @package AltORM\Core\Model
 */
class AltObject
{

	/** @var array  */
	private $_data = array();

	/**
	 * @param $name
	 *
	 * @return mixed
	 */
	public function __get( $name ) {
		if(isset($this->_data[$name]))
			return $this->_data[$name];
	}

	/**
	 * @param $name
	 * @param $value
	 */
	public function __set( $name, $value ) {
		$this->_data[$name] = $value;
	}

	/**
	 * @param $key
	 *
	 * @return $this
	 */
	public function getData($key)
	{
		if(!empty($key)){
			$this->_data[$key];
		}

		return $this;
	}

	public function setData($key, $data)
	{

		if(!empty($data) && !empty($key)){
			$this->_data[$key] = $data;
		}

		return $this;
	}

	/**
	 *
	 * 
	 * @param array $values
	 *
	 * @return $this
	 */
	public function putData($values = [])
	{

		foreach ( $values as $property => $value ) {
			if(property_exists($this, $property))
			{
				$this->{$property} = $value;
			}else{
				$this->setData($property, $value);
			}
		}

		return $this;
	}


}