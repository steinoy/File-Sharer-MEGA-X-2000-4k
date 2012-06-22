<?php defined('SYSPATH') or die('No direct script access.');

class Controller_View extends Controller {
		
		public $template = 'frontend';

		private $id = 0;
		private $entry = null;
		private $aviable_for_preview = array('jpeg', 'jpg', 'png', 'gif', 'swf');

		public function before()
		{
			parent::before();
			$this->id = Helper_AlphaID::id($this->request->param('id'), TRUE);

			$this->entry = ORM::factory('entry')
				->where('id', '=', $this->id)
				->find();

			if(empty($this->entry->id))
			{
			  throw new HTTP_Exception_404('Whaaaa! Nothing here.');
			}
		}
		
		/**
		 * /view/<id>
		 * 
		 * View the presentation of an entry or individual file.
		 */
		public function action_index()
		{
			if (isset($_GET['preview']))
			{
				$this->preview($_GET['preview']);
			}
			else
			{
				$this->list_files();
			}
		}

		/**
		 * Show all files.
		 */
		private function list_files()
		{
			$view = View::factory('view/all')
				->bind('id', $id)
			  ->bind('title', $title)
			  ->bind('expires', $expires)
			  ->bind('files', $files)
			  ->bind('preview_extensions', $this->aviable_for_preview);
			
			$id = $this->entry->id;
			$title = $this->entry->title;
			$expires = $this->entry->get_formatted_expiration();
			$files = $this->entry->get_formatted_files();


			$this->response->body($view);
		}

		/**
		 * Preview an induvidual file.
		 */
		private function preview($file_name)
		{
			$file = $this->entry->get_file_absolute_path($file_name);
			$name_parts = explode('.', strtolower($file_name));
			
			if(in_array(end($name_parts), $this->aviable_for_preview))
			{
				$view = View::factory('view/'.end($name_parts));
			}
			else
			{
				$view = FALSE;
			}

			if( ! $file OR ! $view)
			{
				$this->request->redirect('view/'.$this->request->param('id'));
			}
			else
			{
				$view->bind('src', $src)->bind('size', $size);
			
				$src = $this->entry->get_file_uri($file_name);
				$size = getimagesize($file);

				$this->response->body($view);
			}
		}
}