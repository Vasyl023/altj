<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/26/17
 * Time: 8:50 PM
 */
namespace AltORM\Core\Resource;

use AltORM\AltORM;
use AltORM\Core\Model\AltObject;

/**
 * Class ResourceDb
 * @package AltORM\Core\Resource
 */
class ResourceDb extends AltObject
{

	/** @var string  */
	protected $entityCode = null;

	/** @var array  */
	protected $configs = array();

	/**
	 * ResourceDb constructor.
	 *
	 * @param $entityCode
	 */
	function __construct($entityCode)
	{
		$this->entityCode = $entityCode;
	}

	/**
	 * @return mixed
	 */
	protected function getTable()
	{
		return $this->configs['table'];
	}

	/**
	 * @param $name
	 *
	 * @return array
	 */
	protected function getConfig($name)
	{
		if(!$this->configs) {
			$this->configs = AltORM::getConfig()->getConfigs( $name );
		}
		return $this->configs;
	}
}