<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_List extends Controller_Template {
	
	public $template = 'backend';
	
	/**
		* Users with login privileges
		*/
	public function before()
	{
		parent::before();
		
		if( ! Auth::instance()->logged_in('login'))
		{
			Request::current()->redirect('/user');
		}
	}
	
	/**
	 * /
	 * 
	 * Preload some entires, most is done via main.js.
	 */ 
	public function action_index()
	{
		$this->template->content = View::factory('list/list')
		  ->bind('message', $message)
		  ->bind('user', $user)
		  ->bind('entries', $entries);

		$entries = ORM::factory('entry')
			->read_all(0, 3);
	}

}