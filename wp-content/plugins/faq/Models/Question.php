<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/26/17
 * Time: 9:05 PM
 */

namespace Faq\Models;

use AltORM\Core\Annotations\Table;
use AltORM\Core\Annotations\Column;
use AltORM\Core\AbstractDbModel;


/**
 * @Table(name="question")
 */
class Question extends AbstractDbModel
{

	/** @Column(name="int", primary=true, unique=true, nullable=false, length=11) */
	public $id;

	/** @Column(name="varchar", length=255, nullable=false, default="User") */
	protected $name;

	/** @Column(name="text", nullable=true) */
	protected $question;

	/** @Column(name="text", default="") */
	protected $answer;

	/** @Column(name="int", nullable=false, default="0") */
	protected $is_visible;

	/** @Column(name="datetime", nullable=false) */
	protected $created_at;

	/** @Column(name="varchar", length=255, nullable=false, default="admin") */
	protected $answered_by;

	/**
	 * User constructor.
	 */
	function __construct() {
		parent::__construct('faq/Question');
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
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
	public function getQuestion() {
		return $this->question;
	}

	/**
	 * @param mixed $question
	 */
	public function setQuestion( $question ) {
		$this->question = $question;
	}

	/**
	 * @return mixed
	 */
	public function getAnswer() {
		return $this->answer;
	}

	/**
	 * @param mixed $answer
	 */
	public function setAnswer( $answer ) {
		$this->answer = $answer;
	}

	/**
	 * @return mixed
	 */
	public function getisVisible() {
		return $this->is_visible;
	}

	/**
	 * @param mixed $is_visible
	 */
	public function setIsVisible( $is_visible ) {
		$this->is_visible = $is_visible;
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
	public function getAnsweredBy() {
		return $this->answered_by;
	}

	/**
	 * @param mixed $answered_by
	 */
	public function setAnsweredBy( $answered_by ) {
		$this->answered_by = $answered_by;
	}

}