<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/26/17
 * Time: 9:38 PM
 */

namespace AltORM\Core\Config;

interface ConfigInterface {
	/**
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function getConfigs( $name = '' );

	/**
	 * @param $array
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function addConfig($array, $name = '');

	/**
	 * @param string $name
	 *
	 * @return mixed
	 */
	public function removeConfig( $name = '');

	/**
	 * @return mixed
	 */
	public function cleanCache();

	/**
	 * @return mixed
	 */
	public function saveCache();
}