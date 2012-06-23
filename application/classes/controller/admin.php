<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Admin extends Controller_Template {
	
 	public $template = 'backend';

	/**
	 * Admins only.
	 */
	public function before()
	{
		parent::before();
		
		if( ! Auth::instance()->logged_in('admin'))
		{
			Request::current()->redirect('/');
		}
	}
	
	/**
	 * /admin
	 */
	public function action_index()
	{
			Request::current()->redirect('admin/users');
	}
	
	/**
	 * /admin/users
	 * 
	 * List all users.
	 */
	public function action_users()
	{
		$this->template->content = View::factory('admin/users')
			->bind('errors', $errors)
			->bind('message', $message)
			->bind('users', $users);
				
		$users = ORM::factory('user', array('id' => '*'))->find_all()->as_array();	
	}
}