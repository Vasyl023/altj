<?php
/**
 * Plugin Name: Message system
 * Plugin URI: test.com
 * Description: Message system, which will use alrOrm for testing purpose
 * Version: 0.1.0
 * Author: Vasyl Pastushenko
 * Author URI: my.com
 * License: GPL2
 */


$obj = new \MesSys\Models\UserRepository();


$obj->get(1);

//print_r($obj);die();