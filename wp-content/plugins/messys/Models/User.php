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
 * @Table(name="user")
 */
class User extends AbstractDbModel
{

	/** @Column(name="int", primary=true, unique=true, nullable=false, length=11) */
	public $id;

	/** @Column(name="varchar", length=255, nullable=false, default="User") */
	protected $name;

	/** @Column(name="text", nullable=true) */
	protected $comment;

	/** @Column(name="float", nullable=false, default="10") */
	protected $age;

	/** @Column(name="float", nullable=false, default="10.1") */
	protected $points;

	/** @Column(name="datetime", nullable=false) */
	protected $created_at;

	/** @Column(name="int", nullable=false, default="0") */
	protected $posts;

	/**
	 * User constructor.
	 */
	function __construct() {
		parent::__construct('messys/User');
	}

	/**
	 * @param mixed $id
	 */
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * @param mixed $comment
	 */
	public function setComment( $comment ) {
		$this->comment = $comment;
	}

	/**
	 * @return mixed
	 */
	public function getAge() {
		return $this->age;
	}

	/**
	 * @param mixed $age
	 */
	public function setAge( $age ) {
		$this->age = $age;
	}

	/**
	 * @return mixed
	 */
	public function getPoints() {
		return $this->points;
	}

	/**
	 * @param mixed $points
	 */
	public function setPoints( $points ) {
		$this->points = $points;
	}

	/**
	 * @return mixed
	 */
	public function getCreatedAt() {
		return $this->created_at;
	}

	/**
	 * @param mixed $created_at
	 */
	public function setCreatedAt( $created_at ) {
		$this->created_at = $created_at;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName( $name ) {
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getPosts() {
		return $this->posts;
	}

	/**
	 * @param mixed $posts
	 */
	public function setPosts( $posts ) {
		$this->posts = $posts;
	}


}