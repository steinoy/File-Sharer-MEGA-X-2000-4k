<!doctype html>
<html class="no-js" lang="en">

<head>
	
  <meta charset="utf-8">

  <title><?= Kohana::$config->load('general.title'); ?></title>

  <meta name="viewport" content="width=device-width,initial-scale=1">

  <?= HTML::style('assets/css/style.css'); ?>

  <?php if(isset($header)) : ?>
  	<?= $header; ?>
	<?php endif; ?>

</head>

<body>
	
    <div id="wrap">
	
			<nav id="menu">
				
				<?php
				
				if(Auth::instance()->logged_in() AND ! Auth::instance()->logged_in('login'))
				{
					echo Menu::factory('awaiting');
				}
				else if(Auth::instance()->logged_in('admin'))
				{
					echo Menu::factory('admin');
				}
				else if(Auth::instance()->logged_in('login'))
				{
					echo Menu::factory('login');
				}
				
				?>
				
			</nav>
			
        <?= $content; ?>

    </div>

		<div id="fb-root"></div>
		<script>

		<?php 

		if(ini_get('post_max_size') < ini_get('upload_max_filesize')) {
			$max_size = ini_get('post_max_size');
		} else {
			$max_size = ini_get('upload_max_filesize');
		}

		$max_size = trim($max_size);
    $last = strtolower($max_size[strlen($max_size)-1]);

    switch($last) {
        case 'g':
            $max_size *= 1024;
        case 'm':
            $max_size *= 1024;
        case 'k':
            $max_size *= 1024;
    }

		?>

			_settings = {
				siteURI: '<?= url::site('/'); ?>',
				facebook: {
					id: <?= Kohana::$config->load('facebook.id'); ?>
				},
				maxSize: <?= $max_size; ?>
			};

			(function() {
				var e = document.createElement('script'); e.async = true;
				e.src = document.location.protocol +
				'//connect.facebook.net/en_US/all.js';
				document.getElementById('fb-root').appendChild(e);
			}());
		
		</script>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?= url::base(); ?>assets/js/libs/jquery-1.7.2.min.js"><\/script>')</script>
		
		<?= HTML::script('assets/js/libs/underscore-min.js'); ?>
		
		<?= HTML::script('assets/js/libs/backbone-min.js'); ?>
		
		<?= HTML::script('assets/js/plugins.js'); ?>

		<?php if(isset($footer)) : ?>
			<?= $footer; ?>
		<?php endif; ?>
		
</body>

</html>