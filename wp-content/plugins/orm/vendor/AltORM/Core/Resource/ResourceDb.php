<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/26/17
 * Time: 8:50 PM
 */
namespace AltORM\Core\Resource;

use AltORM\AltORM;

class ResourceDb
{

	/** @var string  */
	protected $entityCode = null;

	function __construct($entityCode)
	{
		$this->entityCode = $entityCode;

	}

	protected function getTable()
	{
		$configs = $this->getConfig($this->entityCode);
		return $configs['table'];
	}

	protected function getConfig($name)
	{
		return AltORM::getConfig()->getConfigs($name);
	}
}