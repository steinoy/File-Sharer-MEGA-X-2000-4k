<!doctype html>
<html class="no-js" lang="en">

<head>
	
  <meta charset="utf-8">

  <title><?= Kohana::$config->load('general.title'); ?></title>

  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?= HTML::style('assets/css/style.css'); ?>

  <style type="text/css">

  	.wrap {
		margin:auto;
		width:<?= $size[0]; ?>px;
	}
	 
	 .center {
		float:left;
		width:<?= $size[0]; ?>px;
	  	height:<?= $size[1]; ?>px;
	}

 	.content {
		height:<?= $size[1]; ?>px;
	   	width:<?= $size[0]; ?>px;
	   	position:absolute;
	   	top:50%;
	   	margin-top:-<?= $size[1] / 2; ?>px;
	}
  </style>

</head>

<body>

<div class="wrap">

	<div class="center">

		 <div class="content">
    		<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="<?= $size[0]; ?>" height="<?= $size[1]; ?>" id="1" align="middle">
  				<param name="movie" value="<?= $src ?>" />
  				<param name="quality" value="high" />
  				<param name="bgcolor" value="#ffffff" />
  				<param name="play" value="true" />
  				<param name="loop" value="true" />
  				<param name="wmode" value="window" />
  				<param name="scale" value="showall" />
  				<param name="menu" value="true" />
  				<param name="devicefont" value="false" />
  				<param name="salign" value="" />
  				<param name="allowScriptAccess" value="sameDomain" />
  				<param name="flashvars" value="" />
  				<!--[if !IE]>-->
  				<object type="application/x-shockwave-flash" data="<?= $src ?>" width="<?= $size[0]; ?>" height="<?= $size[1]; ?>">
  					<param name="movie" value="<?= $src ?>" />
  					<param name="quality" value="high" />
  					<param name="bgcolor" value="#ffffff" />
  					<param name="play" value="true" />
  					<param name="loop" value="true" />
  					<param name="wmode" value="window" />
  					<param name="scale" value="showall" />
  					<param name="menu" value="true" />
  					<param name="devicefont" value="false" />
  					<param name="salign" value="" />
  					<param name="allowScriptAccess" value="sameDomain" />            
  					<param name="flashvars" value="" />
  				</object>
  				<!--<![endif]-->
  			</object>
    </div>

	</div>

</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?= url::base(); ?>assets/js/libs/jquery-1.7.1.min.js"><\/script>')</script>
	
	<?= HTML::script('assets/js/plugins.js'); ?>
	<?= HTML::script('assets/js/preview.js'); ?>

</body>

</html>