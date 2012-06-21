<? if ($message['top']) : ?>
    <div class="message">
        <?= $message['top']; ?>
    </div>
<? endif; ?>

<section id="user-delete" class="full-width user-delete">

<h2 class="first">Are you sure you want to delete <?= $message['username']; ?>?</h2>
<p>
	This will delete everything related to the user, including all the files.
	<br />This is a one way trip and nothing can be restored :(
</p>

<?= Form::open('user/delete/'.Arr::get($user_info, 'id')); ?>
 
<?= Form::hidden('confirmation','1'); ?>
 
<?= Form::submit('delete', 'Yes, please', array('class' => 'submit')); ?>

<a href="<?= url::site('/'); ?>" class="submit">No, get me out of here</a>

<?= Form::close(); ?>

</section>