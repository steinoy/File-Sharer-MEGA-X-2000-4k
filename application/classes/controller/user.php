<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller_Template {
	
	public $template = 'backend';
	
	public function before()
	{
		parent::before();	
	}
	
	/**
	 * /user
	 */
	public function action_index()
	{
		$user = Auth::instance()->get_user();

		if ( ! $user)
		{
			Request::current()->redirect('user/login');
		}
		else
		{
			if( ! Auth::instance()->logged_in('login'))
			{
				Request::current()->redirect('user/awaiting');
			}
			else
			{
				Request::current()->redirect('user/edit/'.$user->id);
			}			
		}
	}
	
	/**
	 * /user/id/edit
	 * 
	 * Edit user info. Users can edit their own info, users with admin role can
	 * edit everyones.
	 */
	public function action_edit()
	{
		$user_to_be_edited = ORM::factory('user', $this->request->param('id'));
		
		if( ! $user_to_be_edited->id OR ! Auth::instance()->logged_in('login'))
		{
			Request::current()->redirect('/user');
		}
		
		// User tries to edit him/her/itself?
		$selfish = ($user = Auth::instance()->get_user() AND $user_to_be_edited->id == $user->id ? TRUE : FALSE);
		
		// Silent redirect if user does not have admin role or if user id does not exist.
		// Selfish users will bypass admin check.
		if(( ! Auth::instance()->logged_in('admin') AND ! $selfish) OR ! $user_to_be_edited->id)
		{
			Request::current()->redirect('/user');
		}
		
		$this->template->content = View::factory('user/edit')
			->bind('errors', $errors)
			->bind('message', $message)
			->bind('user_info', $user_info)
			->bind('admin_options', $admin_options);
				
		$user_info['id'] = $user_to_be_edited->id;
		$user_info['username'] = $user_to_be_edited->username;
		$user_info['facebook_id'] = $user_to_be_edited->facebook_id;
		
		if(Auth::instance()->logged_in('admin'))
		{
			$admin_options = array(
				'roles' => array(),
			);
			
			$user_roles = $user_to_be_edited->roles->find_all()->as_array('name', 'id');
			$all_roles = ORM::factory('role')->find_all()->as_array();
			
			foreach ($all_roles as $role) {
				$admin_options['roles'][$role->id] = array(
					'name' => $role->name,
					'selected' => ! empty($user_roles[$role->name]) ? TRUE : FALSE,
					'description' => $role->description,
					'disabled' => in_array($user_to_be_edited->facebook_id, (array) Kohana::$config->load('facebook.admins')) ? TRUE : FALSE,
				);
			}
		}

		if (HTTP_Request::POST == $this->request->method()) 
		{ 
			try {
				if(Auth::instance()->logged_in('admin'))
				{
					if( ! in_array($user_to_be_edited->facebook_id, (array) Kohana::$config->load('facebook.admins')))
					{	
						$selected_roles = ! empty($_POST['roles']) ? array_keys($_POST['roles']) : array();

						$added_roles = array();
						$removed_roles = array();

						foreach ($all_roles as $role) {
							if(in_array($role->name, $selected_roles) AND empty($user_roles[$role->name]))
							{
								$added_roles[] = $role->id;
								$admin_options['roles'][$role->id]['selected'] = TRUE;
							}
							else if( ! empty($user_roles[$role->name]) AND ! in_array($role->name, $selected_roles))
							{
								$removed_roles[] = $role->id;
								$admin_options['roles'][$role->id]['selected'] = FALSE;
							}
						}

						if( ! empty($added_roles))
						{
							$user_to_be_edited->add('roles', $added_roles);
						}

						if( ! empty($removed_roles))
						{
							$user_to_be_edited->remove('roles', $removed_roles);
						}
					}
				}
				
				$_POST = array();
				$message = 'User updated.';
			} catch (ORM_Validation_Exception $e) {
				$message = 'Problem updating the user.';
				$errors = $e->errors('modules');
			}
		}
	}
	
	public function action_login() 
	{
		$this->template->content = View::factory('user/login')
			->bind('message', $message)
			->bind('login_url', $login_url);

		$this->template->footer = HTML::script('assets/js/login.js');
		
		try {				
			if(Model_Facebook::instance()->logged_in())
			{	
				$user = ORM::factory('user')
					->where('facebook_id', '=', Model_Facebook::instance()->user_id())
					->find();
								
				if($user->id)
				{
					Auth::instance()->force_login($user->username);
				}
				else
				{
					$id = Model_Facebook::instance()->user_id();
					$acc = Model_Facebook::instance()->account();
					
					$user->create_user(
						array(
							'username' => $acc['name'],
							'facebook_id' => $id,
						),
						array(
							'username',
							'facebook_id',
						)
					);

					if(in_array($user->facebook_id, (array) Kohana::$config->load('facebook.admins')))
					{
						$user->add('roles', array(1, 2));
					}				
				}
				
				Request::current()->redirect('/');
			}
			else
			{
				$login_url = Model_Facebook::instance()->facebook()->getLoginUrl(array('next' => url::site('/user/login')));
			}
		} catch (Exception $e) {
			$message = $e->getMessage();
		}
				
	}
	
	/**
	 * /user/delete/<id>
	 * 
	 * Delete all data belonging to a user by user id.
	 */
	public function action_delete()
	{			
		$user_to_be_deleted = ORM::factory('user', $this->request->param('id'));
		
		if( ! $user_to_be_deleted->id OR ! Auth::instance()->logged_in('login'))
		{
			Request::current()->redirect('/user');
		}
		
		// User tries to delete him/her/itself?
		$suicidal = ($user = Auth::instance()->get_user() AND $user_to_be_deleted->id == $user->id ? TRUE : FALSE);
		
		// Silent redirect if user does not have admin role or if user id does not exist.
		// Suicide candidates will bypass admin check.
		if(( ! Auth::instance()->logged_in('admin') AND ! $suicidal) OR ! $user_to_be_deleted->id)
		{
			Request::current()->redirect('/user');
		}
		
		$this->template->content = View::factory('user/delete')
			->bind('message', $message)
			->bind('user_info', $user_info);
		
		$message['username'] = ($suicidal ? 'yourself' : $user_to_be_deleted->username);
		$message['top'] = '';
		
		$user_info['id'] = $user_to_be_deleted->id;
		
		// User has confirmed deletion.
		if (HTTP_Request::POST == $this->request->method())
		{
			$entries = ORM::factory('entry')
				->where('user_id', '=', $user_to_be_deleted->id)
				->find_all()
				->as_array();
			
			foreach ($entries as $entry) {
				$entry->delete();
			}
			
			$user_to_be_deleted->delete();
			$message = 'User deleted.';

			if($suicidal)
			{
				Request::current()->redirect('/user/logout');				
			}
			else
			{
				Request::current()->redirect('/admin/users');
			}
		}		
	}
	
	/**
	 * /user/awaiting
	 * 
	 * Inform the user that they are awaiting approval.
	 */
	public function action_awaiting()
	{
		if( ! Auth::instance()->logged_in() OR Auth::instance()->logged_in('login'))
		{
			Request::current()->redirect('/user');
		}
		
		$this->template->content = View::factory('user/awaiting')
			->bind('message', $message)
			->bind('user_info', $user_info);
			
		$user_info = array(
			'account' => Model_Facebook::instance()->account()
		);
	}
	
	/**
	 * /user/logout
	 * 
	 * Log out user.
	 */
	public function action_logout() 
	{
		Model_Facebook::instance()->facebook()->destroySession();
		Auth::instance()->logout(TRUE);
		
		Request::current()->redirect('user/login');
	}
}