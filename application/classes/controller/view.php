<?php defined('SYSPATH') or die('No direct script access.');

class Controller_View extends Controller {
		
		public $template = 'frontend';

		private $id = 0;
		private $entry = null;
		private $preview = '';
		private $aviable_for_preview = array('jpeg', 'jpg', 'png', 'gif', 'swf');

		public function before()
		{
			parent::before();
			$this->id = Helper_AlphaID::id($this->request->param('id'), TRUE);
			$this->preview = isset($_GET['p']) ? $_GET['p'] : '';

			$this->entry = ORM::factory('entry')
				->where('id', '=', $this->id)
				->find();

			if(empty($this->entry->id))
			{
			  throw new HTTP_Exception_404('This is not the entry you are looking for...');
			}
		}
		
		/**
		 * /view/<id>
		 * 
		 * View the presentation of an entry or individual file.
		 */
		public function action_index()
		{									
			if (empty($this->preview))
			{
				$this->list_files();
			}
			else
			{
				$this->preview();
			}
		}

		/**
		 * Show all files.
		 */
		private function list_files()
		{
			$view = View::factory('view/all')
			  ->bind('title', $title)
			  ->bind('expires', $expires)
			  ->bind('files', $files)
			  ->bind('preview_extensions', $this->aviable_for_preview);
			
			$title = $this->entry->title;
			$expires = $this->entry->get_formatted_expiration();
			$files = $this->entry->get_formatted_files();


			$this->response->body($view);
		}

		/**
		 * Preview an induvidual file.
		 */
		private function preview()
		{
			$file = $this->entry->get_file_absolute_path($this->preview);
			$name_parts = explode('.', strtolower($this->preview));
			
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
			
				$src = $this->entry->get_file_uri($this->preview);
				$size = getimagesize($file);

				$this->response->body($view);
			}
		}
}