<header class="main" role="banner">
	<a class="title" href="<?php echo url() ?>"><?php echo $site->title() ?></a>
	<?php if($user = site()->user() and $user->hasPanelAccess()): ?>
		<a class="button" href="<?php echo $site->url() . '/panel/#/pages/add/blog' ?>" target="_blank">+</a>
	<?php endif ?>
</header>