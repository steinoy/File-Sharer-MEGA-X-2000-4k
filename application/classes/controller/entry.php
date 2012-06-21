<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Entry extends Controller_Backbone {

	/**
	 * Authorize.
	 */
	public function before()
	{
		parent::before();
		
		// Log::instance()->add(Log::NOTICE, $this->request->body());

		if
		(
			! $user = Auth::instance()->get_user() OR
			! $user->has('roles') OR
			! Model_Entry::user_owns_entry($user->id, $this->request->param('id'))
		)
		{
			die('No access.');
		}
	}
	
	public function after()
	{
		parent::after();
	}
}