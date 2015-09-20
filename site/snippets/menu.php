<header class="main" role="banner">
	<a class="title" href="<?php echo url() ?>"><?php echo $site->title() ?>
	<?php if(param('tag')): ?>
		<span class="tag"><?php echo "#" . urldecode(param('tag')) ?></span>
	<?php endif ?></a>
	<div class="description"><div class="content"><?php echo $site->description() ?></div></div>
</header>