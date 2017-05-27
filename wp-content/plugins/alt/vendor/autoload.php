<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/10/17
 * Time: 10:22 PM
 */

/** It`s a root of vendor */
define('BP', __DIR__);

require_once 'vendor/autoload.php';



/**
 * Loading all classes
 * @param $className string - name of class to load
 */
function orm_spl_autoload($className)
{
	$className = BP . DIRECTORY_SEPARATOR . $className . ".php";

	$className = str_replace('\\','/', $className);
	

	if (is_readable($className)) {
		require_once($className);
	}

}

/**
 * @param $className string
 */
function orm_spl_autoload_wp($className)
{
	$className = BP . DIRECTORY_SEPARATOR ."wp" . DIRECTORY_SEPARATOR . $className . ".php";
	$className = str_replace('\\','/', $className);

	if (is_readable($className)) {
		require_once($className);
	}

}

function orm_spl_autoload_wp_plugins($className)
{
	$helper = new \AltORM\Core\Helper\Core();

	$className = $helper->reversePrepareClassPath($className);

	$className = WP_CONTENT_DIR  . DIRECTORY_SEPARATOR .  'plugins' .  DIRECTORY_SEPARATOR . $className . ".php";
	$className = str_replace('\\','/', $className);
//	die($className);

	if (is_readable($className)) {
		require_once($className);
	}
}

spl_autoload_register('orm_spl_autoload');
spl_autoload_register('orm_spl_autoload_wp');
spl_autoload_register('orm_spl_autoload_wp_plugins');

