<?php

namespace Faq\Models;

/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/26/17
 * Time: 12:00 AM
 */
class QuestionRepository extends \AltORM\Repository\AbstractRepository
	implements \AltORM\Repository\RepositoryInterface
{

	/**
	 * UserRepository constructor.
	 */
	function __construct()
	{
		parent::__construct('faq/Question');
	}

	/**
	 * get all visible questions
	 * @return Question[]
	 */
	public function getVisibleQuestions()
	{
		return $this->load(
			[
				'eq' => [
					'column' => 'is_visible',
					'value'  => 1
				]
			]
		);

	}
}