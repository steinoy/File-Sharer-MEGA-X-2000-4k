<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	
	// Set the Facebook app id and secret.
	// (https://developers.facebook.com/apps)
	'app' => array(
		'id' => '1337',
		'secret' => 'xxxxxxxxxxxxxxxxxxxxxxxx',
	),

	// Name => Facebook ID pairs of users that will be granted admin access on first login.
	// Will always keep login and admin roles(can't be edited from the user control).
	// Names are for organizing purposes only it can be 'Whatever name' => Facebook ID
	'admins' => array(
		'name' => 00000000000000,
	),
);