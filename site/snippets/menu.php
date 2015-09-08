<header class="main" role="banner">
	<a class="title" href="<?php echo url() ?>"><?php echo $site->title() ?></a>
	<div class="description"><div class="content"><?php echo $site->description() ?></div></div>
	<?php if(param('tag')): ?>
		<span class="tag"><?php echo "#" . urldecode(param('tag')) ?></span>
	<?php endif ?>
	<?php if($user = site()->user() and $user->hasPanelAccess()): ?>
		<a class="button" href="<?php echo $site->url() . '/panel/#/pages/add/blog' ?>" target="_blank">+</a>
	<?php endif ?>
</header>