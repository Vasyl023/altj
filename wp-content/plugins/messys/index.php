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

/** @var \MesSys\Models\User $user */
$user = $obj->get(3);

//$obj->delete($user);
//$user->setIsNew(true);
//$user->setComment('Vasyl is the best');

//$obj->save($user);

print_r($user);

die();