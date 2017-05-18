<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/1/17
 * Time: 12:54 PM
 */
namespace AltORM\Core\Annotations;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Table
{

	/** @Required */
	public $name;

}