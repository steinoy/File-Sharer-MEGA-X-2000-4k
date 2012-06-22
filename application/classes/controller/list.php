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
	 * Preload some entires for backbone.
	 */ 
	public function action_index()
	{
		$this->template->content = View::factory('list/list')
		  ->bind('message', $message)
		  ->bind('user', $user)
		  ->bind('entries', $entries);

		$models = ORM::factory('entry')->read_all(0, 3);
		$more = ORM::factory('entry')->read_all(3, 1);

		$entries = array(
			'models' => $models,
			'more' => ! empty($more) ? TRUE : FALSE,
		);
	}

}