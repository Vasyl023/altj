<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/24/17
 * Time: 11:17 PM
 */
namespace AltORM\Repository;


use AltORM\Core\AbstractDbModel;

interface RepositoryInterface {

	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function get($id);

	/**
	 * @param AbstractDbModel $obj
	 */
	public function delete(AbstractDbModel $obj);

	/**
	 * @param AbstractDbModel $obj
	 *
	 * @return mixed
	 */
	public function save(AbstractDbModel $obj);

	/**
	 * @param $query array
	 *
	 * @return mixed
	 */
	public function load($query);

}