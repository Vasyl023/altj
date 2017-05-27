<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/29/17
 * Time: 12:41 PM
 */

namespace AltORM\Core\Helper;
use AltORM\Core\Config;

/**
 * Class Core
 * @package AltORM\Core\Helper
 */
class Core
{
	/**
	 * @param $class
	 * @param $plugin
	 *
	 * @return string
	 */
	public function prepareClassPath($class, $plugin)
	{
		$finalPath = explode('-', $plugin);

		$result = '';
		foreach ( $finalPath as $item ) {
			$result .= ucfirst($item);
		}

		return $result  .'\\' .  Config::ORM_MODEL_PATH .'\\' . $class;

	}

	/**
	 * @param $pluginClass
	 *
	 * @return string
	 */
	public function reversePrepareClassPath( $pluginClass )
	{
		$array = explode('\\', $pluginClass);

		if(isset($array[0])){
			$array[0] = strtolower($array[0]);
		}

		$finalPath = implode('\\', $array);

		return $finalPath;

	}

	/**
	 *
	 * Convert property name to PSR-4 getter
	 *
	 * @param $property
	 *
	 * @return string
	 */
	public function getGetterMethodName($property)
	{
		$array = explode('_', $property);

		if(count($array) > 1){
			$result = '';
			foreach ( $array as $item ) {
				$result .= ucfirst($item);
			}
			$prop = $result;
		}else{
			$prop = ucfirst($property);
		}

		return 'get' . $prop;

	}

	public function getSetterMethodName($property)
	{
		$array = explode('_', $property);

		if(count($array) > 1){
			$result = '';
			foreach ( $array as $item ) {
				$result .= ucfirst($item);
			}
			$prop = $result;
		}else{
			$prop = ucfirst($property);
		}

		return 'set' . $prop;

	}
}