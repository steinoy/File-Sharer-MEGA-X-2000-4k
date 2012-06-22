<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Download extends Controller {

	public function before()
	{
		parent::before();

	    $this->profiler = NULL;
	    $this->auto_render = FALSE;
	}

	/**
	 * /download?filename=<id>/<filename>
	 * 
	 * Force the browser to download a file.
	 * Only files in the /files/ directory are available.
	 */
	public function action_index()
	{
		if
		(
			! empty($_GET['filename']) &&
			strpos(realpath(DOCROOT.'files/'.$_GET['filename']), realpath(DOCROOT.'files/')) === 0
		)
		{
			$file = DOCROOT.'files/'.$_GET['filename'];

			if(file_exists($file))
			{
				$this->response->headers('Pragma', 'public');
				$this->response->headers('Expires', '0');
				$this->response->headers('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');
				$this->response->headers('Content-Type', 'application/force-download');
				$this->response->headers('Content-Disposition', 'attachment; filename='.basename($file));
				$this->response->headers('Content-Transfer-Encoding', 'binary');
				$this->response->headers('Content-Length', filesize($file));
				$this->response->headers('Content-Description', 'File Transfer');

				readfile($file);
			}
		}
	}
	
	public function after()
	{
		parent::after();
	}
}