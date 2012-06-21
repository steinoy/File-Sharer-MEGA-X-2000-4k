<? if ($message['top']) : ?>
    <div class="message">
        <?= $message['top']; ?>
    </div>
<? endif; ?>

<section id="user-awaiting" class="full-width user-awaiting">

<h2 class="first">Awaiting approval</h2>
<p>
	Hi there <?= HTML::anchor($user_info['account']['link'], $user_info['account']['first_name'], array('target' => '_blank')); ?>!
</p>

<p>
	Your account needs to be approved by an admin.<br/>
	Please try again after some time.
</p>

</section>