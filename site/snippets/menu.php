<header class="main" role="banner">
	<a class="title" href="<?php echo url() ?>"><?php echo $site->title() ?>
	<?php if(param('tag')): ?>
		<span class="tag"><?php echo "#" . urldecode(param('tag')) ?></span>
	<?php endif ?></a>
	<div class="description"><div class="content"><?php echo $site->description() ?></div></div>

	<aside class="io">
		<div id="input" title="input">i<span class="autohide">nput</span>&ensp;&mdash;</div>
		<div id="output" title="output">&mdash;&ensp;o<span class="autohide">utput</span></div>
	</aside>
</header>