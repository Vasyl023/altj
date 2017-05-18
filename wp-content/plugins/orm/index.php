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



function orm_configuration()
{
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<h1>ORM Configuration</h1>';
	echo '<div class="wrap">';
	echo '<p>Please be careful with ORM configuration it has a big influence on DB.</p>';
	echo '<p>Please send all bugs and your feedback to email <a href="mailto:vasyl007771@gmail.com">Vasyl Pastushenko</a>.</p>';
	echo '<p>Short brief of configurations</p>';
	echo '<textarea style="width: 1000px; height: 300px">';
	print_r(\AltORM\AltORM::getConfig()->getConfigs());
	echo '</textarea>';

	echo '<button class="btn btn-button">Refresh configurations</button>';

	echo '</div>';

}