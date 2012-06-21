<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Cron extends Controller {
	
	/**
	 * /cron
	 * 
	 * Delete expired entries.
	 */ 
	public function action_index()
	{
		$now = date('Y-m-d H:i:s', time());
	  
	  $entries = ORM::factory('entry')
			->where('expires', '<=', $now)
			->and_where('expires', '!=', '0000-00-00')
			->find_all()
			->as_array();
			
			foreach ($entries as $entry) {
				$entry->delete();
			}
	}

}