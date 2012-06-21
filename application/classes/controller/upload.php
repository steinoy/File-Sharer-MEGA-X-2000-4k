<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Upload extends Controller_JSON {

	/**
	 * Authorize.
	 */
	public function before()
	{
		parent::before();
		
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
	 * /upload/files/<id>
	 * 
	 * Upload files related to an entry.
	 */
	public function action_files()
	{
		$entry = ORM::factory('entry', $this->request->param('id'));

		try {
			$entry->save_files($_FILES);
			$this->add('status', 'success');
		} catch (Exception $e) {
			$this->add('status', 'error');
			$this->add('message', $e->getMessage());
		}
	}
	
	public function after()
	{
		parent::after();
	}
}