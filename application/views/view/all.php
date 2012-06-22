<!doctype html>
<html class="no-js" lang="en">

<head>
	
  <meta charset="utf-8">

  <title><?= Kohana::$config->load('general.title'); ?></title>

  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?= HTML::style('assets/css/style.css'); ?>

</head>

<body>
	
    <div id="wrap">

		<h1><?= $title; ?></h1>

		<div id="view-all">

		<?php foreach ($files as $file) : ?>
			<div class="entry">
				<h3>
					<a href="<?= $file['URI']; ?>">
						<?= $file['name']; ?>
					</a>
				</h3>

				<div class="actions">

					<a class="download" href="<?= url::site('/'); ?>?p=<?= $file['name'] ?>" target="_blank">Preview</a>
				
					<?php $name_parts = explode('.', strtolower($file['name'])); ?>
				
					<?php if(in_array(end($name_parts), $preview_extensions)) : ?>
					
					<a class="preview" href="<?= url::site('/'); ?>?p=<?= $file['name'] ?>" target="_blank">Preview</a>

					<?php endif; ?>

				</div>

			</div>
		<?php endforeach; ?>

		</div>

	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?= url::base(); ?>assets/js/libs/jquery-1.7.1.min.js"><\/script>')</script>
	
	<script>

	$('a.preview-link').live('click', function(e) {
		e.preventDefault();
		var link = this;

		$('#wrap').fadeOut(200, 0, function() {
			$('body').prepend('<div id="preview-overlay"></div><iframe id="preview-frame" src="'+$(link).attr('href')+'" width="100%" height="99%" style="height:100%;" scrolling="no"  frameborder="0"></iframe>');
			$('#preview-frame').css({
				'height': $(window).height()-10+'px'
			});
		});
	});

	$('#preview-overlay').live('click', function() {
		$('#preview-overlay, #preview-frame').remove();
		$('#wrap').fadeIn();
	});

	</script>

</body>

</html>