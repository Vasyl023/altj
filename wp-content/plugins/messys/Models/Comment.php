<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/26/17
 * Time: 9:05 PM
 */
namespace MesSys\Models;

use AltORM\Core\Annotations\Table;
use AltORM\Core\Annotations\Column;
use AltORM\Core\AbstractDbModel;

/**
 * @Table(name="comment")
 */
class Comment extends AbstractDbModel
{
	/** @Column(name="string") */
	public $text;

	/** @Column(name="date") */
	protected $date;

	/**
	 * User constructor.
	 */
	function __construct() {
		parent::_construct('mes-sys/comment');
	}



}