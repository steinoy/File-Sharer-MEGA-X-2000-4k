<?php
/**
* Taken from https://github.com/zombor/Kohana-Facebook, a bit modified.
*
* @author         Jeremy Bush
* @copyright      (c) 2010 Jeremy Bush
* @license        http://www.opensource.org/licenses/isc-license.txt
*/
class Model_Facebook
{
	protected static $_instance;

	protected $_facebook;

	protected $_me;

	protected function __construct()
	{
		include Kohana::find_file('vendor', 'facebook/src/facebook');

		// Do class setup
		$this->_facebook = new Facebook(
			array(
				'appId'  => Kohana::$config->load('facebook.id'),
				'secret' => Kohana::$config->load('facebook.secret'),
			)
		);

		try
		{
			$this->_me = $this->_facebook->api('/me');
		}
		catch (FacebookApiException $e)
		{
			// Do nothing.
		}
	}

	public static function instance()
	{
		if ( ! isset(self::$_instance))
			Model_Facebook::$_instance = new Model_Facebook;

		return Model_Facebook::$_instance;
	}

	public function app_id()
	{
		return $this->_facebook->getAppId();
	}

	public function logged_in()
	{
		return $this->_me != NULL;
	}

	public function user_id()
	{
		return $this->_facebook->getUser();
	}

	public function account()
	{
		return $this->_me;
	}

	public function facebook()
	{
		return $this->_facebook;
	}
}