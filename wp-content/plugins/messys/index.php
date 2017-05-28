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

$user->setIsNew(true);
$user->setComment('ALtORM is the best');
$user->setAge(30);

$obj->save($user);

