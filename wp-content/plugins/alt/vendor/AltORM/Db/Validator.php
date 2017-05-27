<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 5/7/17
 * Time: 1:53 PM
 */

namespace AltORM\Db;


class Validator {

	static private $valid;

	/** @var \wpdb  */
	protected $_wpdb;

	function __construct() {
		global $wpdb;

		$this->_wpdb = $wpdb;
	}

	static public function validator()
	{
		if(!self::$valid){
			self::$valid = new Validator();
		}
		return self::$valid;
	}


	/**
	 * @return \wpdb
	 */
	public function getWpdb()
	{
		return $this->_wpdb;
	}

	/**
	 * @param string      $query    Query statement with sprintf()-like placeholders
	 * @param array|mixed $args     The array of variables to substitute into the query's placeholders if being called like
	 *                              {@link https://secure.php.net/vsprintf vsprintf()}, or the first variable to substitute into the query's placeholders if
	 *                              being called like {@link https://secure.php.net/sprintf sprintf()}.
	 * @param mixed       $args,... further variables to substitute into the query's placeholders if being called like
	 *                              {@link https://secure.php.net/sprintf sprintf()}.
	 * @return string Sanitized query string, if there is a query to prepare.
	 */
	public function validate($query, ...$args)
	{
		return $this->getWpdb()->prepare($query, $args);
	}
}