<? if ($message) : ?>
    <div class="message">
        <?= $message; ?>
    </div>
<? endif; ?>

<section id="user" class="full-width user edit">

<div class="img">
	
	<a href="http://www.facebook.com/profile.php?id=<?= $user_info['facebook_id']; ?>" target="_blank">
		<img src="https://graph.facebook.com/<?= $user_info['facebook_id']; ?>/picture">
	</a>

</div>

<a class="user-title" href="http://www.facebook.com/profile.php?id=<?= $user_info['facebook_id']; ?>" target="_blank">
	<?= $user_info['username']; ?>
</a>

<?php if( ! empty($admin_options)) : ?>

	<?= Form::open('user/edit/'.Arr::get($user_info, 'id')); ?>

	<?php if( ! empty($admin_options['roles'])) : ?>
	
	<div class="option-section">
		
		<h4 class="option-title">Roles</h4>
		
		<?php foreach ($admin_options['roles'] as $role) : ?>
			
			<div class="check-box entry">
				
				<?php 

				$attr = array();
				
				if($role['disabled'])
				{
					$attr['disabled'] = 'disabled';
				}

				?>

				<?= Form::checkbox('roles['.$role['name'].']', NULL, $role['selected'], $attr); ?>
				
				<?= Form::label('roles['.$role['name'].']', ucfirst($role['name'])); ?>
				
				<div class="description">
					<?= $role['description'] ?>
				</div>
				
				<?php next($admin_options['roles']); ?>
			
			</div>

		<?php endforeach; ?>
	
	</div>
	
	<?php endif; ?>

	<div class="user-edit-actions">

		<?= Form::submit('update', 'Update user', array('class' => 'submit')); ?>

		<a href="<?= url::site('/user/delete'); ?>/<?= Arr::get($user_info, 'id'); ?>" class="submit">Delete user</a>

	</div>

	<?= Form::close(); ?>

<?php else : ?>
	
	<div class="user-edit-actions">
		
		<a href="<?= url::site('/user/delete'); ?>/<?= Arr::get($user_info, 'id'); ?>" class="submit">Delete user</a>

	</div>
	
<?php endif; ?>

</section>