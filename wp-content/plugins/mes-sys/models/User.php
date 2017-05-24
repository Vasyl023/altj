<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/26/17
 * Time: 9:05 PM
 */
use AltORM\Core\Annotations\Table;
use AltORM\Core\Annotations\Column;
use AltORM\Core\AbstractDbModel;

/**
 * @Table(name="user")
 */
class User extends AbstractDbModel
{
	/** @Column(name="int", primary=true, unique=true, nullable=false, length=11) */
	public $id;

	/** @Column(name="varchar", nullable=true) */
	protected $last;

	/** @Column(name="text", nullable=true) */
	protected $comment;

	/** @Column(name="int", nullable=false, default="10") */
	protected $age;

	/** @Column(name="decimal", nullable=false, default="10.1") */
	protected $points;

	/** @Column(name="datetime", nullable=false) */
	protected $created_at;

	/**
	 * User constructor.
	 */
	function __construct() {
		parent::_construct('mes-sys/user');
	}
}