<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Entry extends Model_Backbone {
	
	const TABLE = 'entries';

	protected $_table_name  = 'entries';

  protected $_table_columns = array(
    'id' => NULL,
    'user_id' => NULL,
    'title' => NULL,
    'expires' => NULL,
    'published' => NULL,
  ); 

	/**
	 * @param   array  input values
	 * @throws  ORM_Validation_Exception
	 */
	public function create_model($values)
	{
		return $this->values($this->filter_values($values), array('title', 'published', 'expires', 'user_id'))->create();
	}

	/**
	 * Returns an array with all models, each model containing the 
	 * Backbone attributes.
	 * 
	 * @param int $from Define offset(optional)
	 * @param int $to Define limit(optional)
	 * @return  array  containing all models
	 */
	public function read_all($from = NULL, $to = NULL)
	{
		$data = array();

		$entries = $this->where('user_id', '=', Auth::instance()->get_user()->id)
			->offset($from)
			->limit($to)
			->order_by('published', 'desc')
			->find_all();

		foreach ($entries AS $model)
		{
			$data[] = $model->as_array();
		}

		return $data;
	}

	/**
	 * @param   array  input values
	 * @throws  ORM_Validation_Exception
	 */
	public function update_model($values)
	{
		if( ! empty($values['deleteList']))
		{
			$this->delete_files($values['deleteList']);
		}

		return $this->values($this->filter_values($values), array('title', 'published', 'expires', 'user_id'))->update();
	}

	/**
	 * @return  array  containing the Backbone attributes
	 */
	public function as_array()
	{
		return array(
			'id' => $this->id,
			'title' => $this->title,
			'published' => $this->get_formatted_published(),
			'expires' => $this->get_formatted_expiration(),
			'URI' => $this->get_entry_URI(),
			'fileNames' => $this->get_formatted_file_names(),
			'deleteList' => array(),
		);
	}

	/**
	 * Extract the needed values from Backbone.
	 * 
	 * @param array $values The values
	 */
	public function filter_values($values)
	{	
		$new_values = array();

		$new_values['title'] = $values['title'];

		if(empty($this->id))
		{			
			$new_values['published'] = date('Y-m-d G:i:s', time());			
		}

		if( ! is_numeric($values['expires']))
		{
			$new_values['expires'] = '0000-00-00'; // Never
		}
		else
		{
			$now = time();
			$new_time = strtotime('+'.$values['expires'].' days', $now);
			$new_values['expires'] = date('Y-m-d', $new_time);
		}

		$new_values['user_id'] = Auth::instance()->get_user()->id;

		return $new_values;
	}
	
	/**
	 * Save files.
	 * 
	 * @param array $args List of files.
	 * @return Model_Entry
	 */
	public function save_files(Array $files)
	{
		$saved_files = array();
		$dir = DOCROOT.'files/'.$this->id;

		if( ! file_exists($dir))
		{
			mkdir($dir);
		}
		
		$allowed_extensions = (Array) Kohana::$config->load('allowed_extensions');
		
		foreach($files as $file) {
			
			if ($file['tmp_name'] > '')
			{ 
				$name_parts = explode('.', strtolower($file['name']));
				
				if ( ! in_array(end($name_parts), $allowed_extensions))
				{
					throw new Exception('File type not allowed: '.$file['name'], 1);
				} 
			}
			
			$path = $dir.'/'.$file['name'];

			move_uploaded_file($file['tmp_name'], $path);
		}

		return $this;
	}
	
	/**
	 * Delete files related to this entry.
	 * 
	 * @param array $file_names Names of files to delete
	 * @return Model_Entry
	 */
	public function delete_files(Array $file_names)
	{		
		foreach ($file_names as $file_name) {
			$path = DOCROOT.'files/'.$this->id.'/'.$file_name;
			
			if(file_exists($path))
			{
				unlink($path);
			}
		}
		
		return $this;
	}

	/**
	 * Check if the user owns the entry.
	 * 
	 * @param int $user_id The user id
	 * @param int $entry_id The entry id
	 * @return bool True if user owns the entry or if it's a new entry
	 */
	public static function user_owns_entry($user_id, $entry_id)
	{
		$user_id_from_entry = DB::select('user_id')->from(self::TABLE)->where('id', '=', $entry_id)->execute();
		
		if(empty($user_id_from_entry[0]['user_id']))
		{
			return TRUE;
		}
		else
		{
			if($user_id === $user_id_from_entry[0]['user_id'])
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
	}
	
	/**
	 * Deletes a single record or multiple records, ignoring relationships.
	 *
	 * @chainable
	 * @return ORM
	 */
	public function delete()
	{
		if ( ! $this->_loaded)
			throw new Kohana_Exception('Cannot delete :model model because it is not loaded.', array(':model' => $this->_object_name));

		$dir_path = DOCROOT.'files/'.$this->id;

		if(file_exists($dir_path))
		{
			$d = dir($dir_path); 

			while($entry = $d->read()) { 
				if ($entry!= "." AND $entry!= "..") { 
		 			unlink(DOCROOT.'files/'.$this->id.'/'.$entry); 
		 		}
		 	}

		 	$d->close(); 
			rmdir($dir_path); 
		}

		// Use primary key value
		$id = $this->pk();

		// Delete the object
		DB::delete($this->_table_name)
			->where($this->_primary_key, '=', $id)
			->execute($this->_db);

		return $this->clear();
	}
	
	/**
	 * Get days until expiration.
	 * 
	 * @return mixed Difference in days between today and the expiration date or 'never'
	 */
	public function get_formatted_expiration() {
		$date = $this->expires;
		$expires = '';
		
		if($date === '0000-00-00')
		{
			$expires = '&#8734;';
		}
		else
		{
			$expires = explode('-', $date);
			$expires = mktime(0, 0, 0, $expires[1], $expires[2], $expires[0]);
			$expires = ceil(abs($expires - time())/60/60/24);
		}
		
		return $expires;
	}
	
	/**
	 * Get the date published.
	 * 
	 * @return The date in dd-mm format.
	 */
	public function get_formatted_published()
	{
		$published = date('d/m', strtotime($this->published));
		
		return $published;
	}
	
	/**
	 * Get a list of the files with relevant info such as filename and URI.
	 * 
	 * @return array The files with names and URIs
	 */
	public function get_formatted_files()
	{
		$files = array();
		
		$dir_files = scandir(DOCROOT.'files/'.$this->id);

		foreach($dir_files as $file_name) {
			if ($file_name != '.' AND $file_name != '..') {
				$files[] = array(
					'name' => $file_name,
					'URI' => $this->get_file_URI($file_name)
				);
			}
		}
		
		return $files;
	}

	/**
	 * Get a list of the file names related to this entry.
	 * 
	 * @return array The file names
	 */
	public function get_formatted_file_names()
	{
		$file_names = array();
		
		$dir = DOCROOT.'files/'.$this->id;

		if(file_exists($dir)) {
			$dir_files = scandir(DOCROOT.'files/'.$this->id);

			foreach($dir_files as $file_name) {
				if ($file_name != '.' AND $file_name != '..') {
					$file_names[] = $file_name;
				}
			}
		}

		return $file_names;
	}

	/**
	 * Get the absolute path for an individual file.
	 * 
	 * @param string $file_name Name of the file
	 * @return The file path if file exists, else false.
	 */
	public function get_file_absolute_path($file_name)
	{	
		$path_name = DOCROOT.'files/'.$this->id.'/'.$file_name;

		if(file_exists($path_name))
		{
			return $path_name;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Get the URI for an individual file.
	 * 
	 * @param string $file_name Name of the file
	 * @return The file URI
	 */
	public function get_file_URI($file_name)
	{			
		return url::site(NULL, TRUE).'files/'.$this->id.'/'.$file_name;
	}

	/**
	 * Get the URI for this entry.
	 * 
	 * @return The entry URI
	 */
	public function get_entry_URI()
	{			
		return url::site(NULL, TRUE).'view/'.Helper_AlphaID::id($this->id);
	}
	
	/**
	 * Taken from http://stackoverflow.com/a/2727693
	 * 
	 * Sanitize string to strip it from dangerous and silly charackters.
	 * 
	 * @param string $string The string to sanitize
	 * @return Sanitized string
	 */
	public static function sanitize_file_name($string) {
		$safe_name = strtr($string, 'ŠŽšžŸÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝàáâãäåçèéêëìíîïñòóôõöøùúûüýÿ', 'SZszYAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy');
		$safe_name = strtr($safe_name, array('Þ' => 'TH', 'þ' => 'th', 'Ð' => 'DH', 'ð' => 'dh', 'ß' => 'ss', 'Œ' => 'OE', 'œ' => 'oe', 'Æ' => 'AE', 'æ' => 'ae', 'µ' => 'u'));

		$safe_name = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), $safe_name);
		
		return $safe_name;
	}
	
} // End entry Model