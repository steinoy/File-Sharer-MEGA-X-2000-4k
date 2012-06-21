<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	'driver' => 'file', // you can use 'database' or 'file', database uses ORM driver
	'view' => 'menu', // the view file
	'current_class' => 'current', // the set_current() method uses this setting to mark the current menu item

	'items' => array
	(	
		array
		(
			'url'   => url::site('/'),
			'title' => 'Files',
			'classes' => array('shy-button')
		),
		array
		(
			'url'   => url::site('/user'),
			'title' => 'Account',
			'classes' => array('shy-button')
		),
		array
		(
			'url'   => url::site('/admin'),
			'title' => 'Admin',
			'classes' => array('shy-button')
		),
		array
		(
			'url'   => url::site('/user/logout'),
			'title' => 'Log out',
			'classes' => array('shy-button')
		),
	),

);