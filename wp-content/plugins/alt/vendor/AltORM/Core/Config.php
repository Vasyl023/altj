<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/26/17
 * Time: 9:25 PM
 */

namespace AltORM\Core;

use AltORM\Core\Annotation\Parser;
use AltORM\Core\Annotation;
use AltORM\Core\Annotation\AnnotationInterface;
use AltORM\Core\Helper\Core as Helper;
use AltORM\Core\Config\ConfigInterface;
use AltORM\Core\Helper\Core;
use Symfony\Component\Yaml\Yaml;

class Config implements ConfigInterface
{

	const YML_CONFIG_NAME = 'alt-conf.yml';

	const WP_CONTENT_PLUGIN_DIR = 'plugins';

	const WP_OPTION_NAME = 'alt-orm-cache';

	const ORM_CLASS_ENDING = '.php';

	const ORM_MODEL_PATH = 'Models';

	/** @var bool  */
	private $_isFoldersParsed = false;


	/** @var  array */
	protected $_configs;

	/** @var AnnotationInterface */
	protected $_parser = null;

	/**
	 * Config constructor.
	 * Go through all plugins and collect data about plugins
	 */
	function __construct() {

		if(get_option(self::WP_OPTION_NAME) == ''){
			$this->_prepareConfigs(true);
		}else{
			$this->_configs = unserialize(get_option(self::WP_OPTION_NAME));
		}

	}

	/**
	 * Save data to cache
	 */
	public function saveCache()
	{
		add_option(self::WP_OPTION_NAME, serialize($this->getConfigs()));
	}

	/**
	 * Save data to cache
	 */
	public function cleanCache()
	{
		add_option(self::WP_OPTION_NAME, '');
	}

	/**
	 * Here we get all folders of plugin with config file
	 * @param $isForced boolean
	 *
	 */
	private function _prepareConfigs($isForced = false)
	{
		if(!$this->_isFoldersParsed || $isForced){

			$plugin_dirs = get_plugins();

			/** @var array $dirs */
			$dirs = array();
			$helper = new Core();

			//parse directories
			$root_dir = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . self::WP_CONTENT_PLUGIN_DIR;

			foreach ( $plugin_dirs as $key => $plugin_dir ) {

				if (strpos($key, '/') === false) {
					continue;
				}
				// need to get directory
				$file = explode('/', $key);

				if(!isset($file[0])){
					continue;
				}
				// create dir
				$dirs[] =  $file[0] ;

			}

			// check files
			// and load configs
			foreach ( $dirs as $dir ) {

				$confPath = $root_dir . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . self::YML_CONFIG_NAME;

				if(!file_exists($confPath))
					continue;

				$yml = Yaml::parse(file_get_contents($confPath));

				//validate
				$this->validateConfigYml($yml);

				$classes = $yml['class']['classes'];
				$classesFolder = self::ORM_MODEL_PATH;
				$alias = $yml['db']['prefix'];
				// generate per class configs

				// Params for parsing data from  class
				$params = array('alias' => $alias);

				foreach ( $classes as $class ) {

					$classId = $dir . DIRECTORY_SEPARATOR . $class;

					$finalClass = $helper->prepareClassPath($class, $dir);

					$modelPath = $root_dir . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR
					             . $classesFolder . DIRECTORY_SEPARATOR . $class . self::ORM_CLASS_ENDING;

					$this->addConfig(
						$this->getParser()->parseClass($modelPath, $finalClass, $params),
						$classId
					);

				}
			}
			$this->_isFoldersParsed = true;

			// after let`s save a cache
			$this->saveCache();
		}


	}

	/**
	 * @param $yml
	 *
	 * @throws \Exception
	 */
	protected function validateConfigYml($yml)
	{
		if(!isset($yml['class'])){
			throw new \Exception('No class type provided');
		}

		if(!isset($yml['class']['classes'])){
			throw new \Exception('No classes type provided');
		}

	}

	/**
	 * Get config array
	 *
	 * @param string $name
	 *
	 * @return array
	 */
	public function getConfigs($name = '')
	{

		if(empty($name))
			return $this->_configs;

		return $this->_configs[$name];
	}

	/**
	 * @param $array
	 * @param string $name
	 *
	 * @return mixed|void
	 * @throws \Exception
	 */
	public function addConfig($array, $name = '')
	{
		if(isset($this->_configs[$name])){
			throw new \Exception('Class with this name already stored in Alt ORM configs.');
		}

		$this->_configs[$name] = $array;

	}

	public function removeConfig( $name = '' ) {
	}


	/**
	 * Get annotation parser
	 *
	 * @return Annotation\AnnotationInterface
	 */
	public function getParser()
	{

		if(is_null($this->_parser)){
			$this->_parser = new Parser();
		}

		return $this->_parser;
	}
}