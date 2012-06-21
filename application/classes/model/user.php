<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends Model_Auth_User {

	protected $_table_name  = 'users';

  protected $_table_columns = array(
    'id' => NULL,
    'username' => NULL,
    'logins' => NULL,
    'last_login' => NULL,
    'facebook_id' => NULL,
  ); 
	
	/**
	 * Rules for the user model.
	 *
	 * @return array Rules
	 */
	public function rules()
	{
		return array(
			'username' => array(
				array('not_empty'),
				array(array($this, 'unique'), array('username', ':value')),
			),
			'facebook_id' => array(
				array('not_empty'),
				array(array($this, 'facbook_is_unique'))
			)
		);
	}
	
	/**
	 * Check if Facebook id already exists.
	 * 
	 * @param $id
	 * @return boolean
	 */
	public function facbook_is_unique($id)
	{
		return ! $this->unique_key_exists($id, 'facebook_id');
	}
	
	/**
	 * Get Facebook stuff
	 * 
	 * @param array $stuff What to fetch from Facebook
	 * @return Array
	 */
	public function facebook_stuff(Array $stuff)
	{
		$select = '';
		
		foreach ($stuff as $value) {
			$select .= $value.', ';
		}
		
		$select = substr($select, 0, -2);

		$fql = 'SELECT '.$select.' from user where uid = '.$this->facebook_id;

		return Model_Facebook::instance()->facebook()->api(array(
			                                   'method' => 'fql.query',
			                                   'query' => $fql,
			                                 ));
	}
	
	/**
	 * Create a new user
	 * 
	 * @param array $values
	 * @param array $expected
	 * @throws ORM_Validation_Exception
	 */
	public function create_user($values, $expected)
	{		
		return $this->values($values, $expected)->create();
	}

} // End User Model