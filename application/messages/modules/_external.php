<?php defined('SYSPATH') or die('No direct script access.');

return array(
		'password' => array(
	      'not_empty' => 'Password must not be empty.',
	      'min_length' => 'Pasword must be at least :param2 characters long.',
	      'max_length' => 'Password cannot exceed :param2 characters.',
	  ),
		'password_confirm' => array(
	      'matches' => 'Password confirmation did not match.',
	  ),
	
);
