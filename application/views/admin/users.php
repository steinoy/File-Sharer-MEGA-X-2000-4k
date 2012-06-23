<? if ($message) : ?>
<section class="message">
	<?= $message; ?>
</section>
<? endif; ?>

<section id="files-list" class="full-width files-list">
	
	<h2 class="first">Administer users</h2>
	
	<? $first = 'first';?>
	<ul id="users" class="full-width users">
		
	<? foreach($users as $user) : ?>
		
			<li class="user <?= $first; ?>">

				<a href="<?= url::site('/user/edit')?>/<?= $user->id ?>" class="link">

					<h3><?= $user->username; ?></h3>

				</a>
				
				<div class="actions">
					<a href="<?= url::site('/user/edit')?>/<?= $user->id; ?>" class="edit">Edit</a>
					<a href="<?= url::site('/user/delete')?>/<?= $user->id; ?>" class="user-delete">Delete</a>
				</div>

			</li>
			
	<? $first = ''; ?>
	<? endforeach; ?>
	
	</ul>
</section>