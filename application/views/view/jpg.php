<!doctype html>
<html class="no-js" lang="en">

<head>
	
  <meta charset="utf-8">

  <title><?= Kohana::$config->load('general.title'); ?></title>

  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?= HTML::style('assets/css/style.css'); ?>

</head>

<body>
	
    <div id="preview" class="img" style="width:<?= $size[0] ?>px;">
    	
    	<img src="<?= $src ?>" />

	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?= url::base(); ?>assets/js/libs/jquery-1.7.1.min.js"><\/script>')</script>
	
	<?= HTML::script('assets/js/plugins.js'); ?>
	<?= HTML::script('assets/js/preview.js'); ?>

</body>

</html>