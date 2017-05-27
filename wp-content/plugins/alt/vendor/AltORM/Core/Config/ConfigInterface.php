<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/26/17
 * Time: 9:38 PM
 */

namespace AltORM\Core\Config;

interface ConfigInterface {
	public function getConfigs( $name = '' );
	public function addConfig($array, $name = '');
	public function removeConfig( $name = '');
}