<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/10/17
 * Time: 11:03 PM
 */

namespace AltORM;

// including wpdb class for proper working
require_once ABSPATH . WPINC . '/wp-db.php';

use AltORM\Core\Config;
use AltORM\Db\Pdo;
use wpdb;

/**
 * Class AltORM
 * Main class in whole module. Responsible for running commands in pdo
 * @package AltOrm
 */
class AltORM {

	/** @var AltORM  */
	static private $_orm = null;


	static private $_config = null;

	/** @var  wpdb  */
	private $_wpdb;


	/**
	 * AltORM constructor.
	 *
	 * @param $wpdb wpdb
	 */
	function __construct(
		wpdb $wpdb
	) {
		$this->_wpdb = $wpdb;
	}

	/**
	 * Run migrations
	 */
	public function bootstrap()
	{
		// check cache
		$this->_runMigration();
	}

	/**
	 * Run all app migration.
	 *
	 */
	private function _runMigration()
	{
		$configs = self::getConfig()->getConfigs();

		$pdo = Pdo::getInstance();

		foreach ( $configs as $name => $config )
		{
			$pdo->createTable($config['table'], $config['columns']);
		}

	}

	/**
	 *
	 * Singleton
	 *
	 * @return AltORM
	 */
	public static function orm()
	{
		if(self::$_orm == null){
			global $wpdb;


			self::$_orm = new AltORM($wpdb);
			self::$_config = AltORM::getConfig();

			// start real orm functions
			self::$_orm->bootstrap();
		}

		return self::$_orm;
	}

	/**
	 * Preparing configs
	 *
	 * @return Config\ConfigInterface
	 */
	public static function getConfig()
	{
		if(self::$_config == null){

			self::$_config = new Config();
		}

		return self::$_config;

	}
}