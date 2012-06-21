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
				
        <section id="user-delete" class="full-width user-delete">

				<h2 class="first">Whoops!</h2>
				<p><?= $type ?></p>

				</section>

    </div>

</body>

</html>