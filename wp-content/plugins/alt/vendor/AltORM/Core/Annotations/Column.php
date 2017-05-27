<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/1/17
 * Time: 3:01 PM
 */
namespace AltORM\Core\Annotations;
use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Attributes;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Column
{
	/** @Required */
	public $name;

	/** @var boolean */
	public $primary;

	/** @var boolean */
	public $unique;

	/** @var int */
	public $length;

	/** @var boolean */
	public $nullable;

	/** @var string */
	public $default;

}