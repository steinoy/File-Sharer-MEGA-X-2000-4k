<? if ($message) : ?>
<section class="message">
	<?= $message; ?>
</section>
<? endif; ?>

<section id="login" class="full-width login">
	<div class="full-width login-actions">
		
		<?= HTML::anchor($login_url, 'Log in', array('class' => 'submit login-submit facebook', 'title' => 'Log in with Facebook', 'id' => 'fb-login')); ?>
				 
	</div>

</section>