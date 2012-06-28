<!doctype html>
<html class="no-js" lang="en">

<head>
	
  <meta charset="utf-8">

  <title><?= Kohana::$config->load('general.title'); ?></title>

  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?= HTML::style('assets/css/style.css'); ?>

  <style type="text/css">
  	img {
  		position:absolute;
  		top:50%;
  		left:50%;
  		margin-left:-<?= $size[0] / 2 ?>px;
  		margin-top:-<?= $size[1] / 2 ?>px;
  	}
  </style>

</head>

<body>
	
    	
    <img src="<?= $src ?>" width="<?= $size[0] ?>" height="<?= $size[1] ?>" />

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?= url::base(); ?>assets/js/libs/jquery-1.7.1.min.js"><\/script>')</script>
	
	<?= HTML::script('assets/js/plugins.js'); ?>
	<?= HTML::script('assets/js/preview.js'); ?>

</body>

</html>