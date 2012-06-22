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

	/**
	 * Returns all models as JSON
	 */
	public function action_read()
	{
		try
		{
			if( ! empty($_GET['offset']))
			{
				$this->response->body(json_encode($this->_model->read_all($_GET['offset'], 3)));
			}
			else
			{
				// Read all models
				$this->response->body(json_encode($this->_model->read_all()));
			}
		}
		catch (Kohana_Exception $e)
		{
			// Return HTTP 400: Bad Request
			$this->response->status(400);
		}
	}
	
	public function after()
	{
		parent::after();
	}
}