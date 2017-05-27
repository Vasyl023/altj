<?php
/**
 * Plugin Name: AltORM
 * Plugin URI: xxx
 * Description: WP orm
 * Version: 0.0.1
 * Author: Vasyl Pastushenko
 * Author URI: vk.com
 * License: GPL2
 */
//loading our core files

require_once __DIR__. '/vendor/autoload.php';
require_once ABSPATH . DIRECTORY_SEPARATOR . 'wp-admin/includes/plugin.php';
require_once __DIR__. '/views/init-admin.php';

\AltORM\AltORM::orm();


add_action( 'admin_menu', 'altorm_menu' );


function altorm_menu() {
	add_options_page( 'ORM Configuration', 'ORM Configuration', 'manage_options', 'my-unique-identifier', 'orm_configuration' );
}
