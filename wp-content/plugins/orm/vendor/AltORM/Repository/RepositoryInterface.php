<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/24/17
 * Time: 11:17 PM
 */

interface RepositoryInterface {

	public function get($id);

	public function save(\AltORM\Core\Model\AltObject $obj);

	public function load($query);

}