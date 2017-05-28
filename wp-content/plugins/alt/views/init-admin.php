<?php
/**
 * Created by PhpStorm.
 * User: Vasyl
 * Date: 4/10/17
 * Time: 11:26 PM
 */


function orm_configuration()
{
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	if(isset($_GET['clean-cache']) && $_GET['clean-cache'] == 1){
		add_option(\AltORM\AltORM::getConfig()->cleanCache(), '');
	}
	echo '<h1>ORM Configuration</h1>';
	echo '<div class="wrap">';
	echo '<p>Please be careful with ORM configuration it has a big influence on DB.</p>';
	echo '<p>Please send all bugs and your feedback to email <a href="mailto:vasyl007771@gmail.com">Vasyl Pastushenko</a>.</p>';
	echo '<p>Short brief of configurations</p>';
	echo '<textarea style="width: 1000px; height: 300px">';
	print_r(\AltORM\AltORM::getConfig()->getConfigs());
	echo '</textarea>';
	$url = admin_url( 'options-general.php?page=my-unique-identifier&clean-cache=1' );
	echo '<br/>';
	echo '<button onClick="document.location=\''.$url.'\'" class="btn btn-button">Refresh configurations</a>';

	echo '</div>';

}