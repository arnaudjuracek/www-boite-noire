<!DOCTYPE html>
<html lang="<?php echo $site->htmllang()->html() ?>">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0">

	<title><?php echo $site->title()->html() ?> | <?php echo (param('tag')) ? "#" . urldecode(param('tag')) : $page->title()->html() ?></title>
	<meta name="description" content="<?php echo $site->description()->html() ?>">
	<meta name="keywords" content="<?php echo $site->keywords()->html() ?>">
		<?php snippet('less') ?>
		<?php add_to_visited_links(kirby()->request()->url());?>
		<?php snippet('modernizr_touch'); ?>
</head>
<body data-template="<?php echo $page->template(); ?>">
<script>
	if(document.body.style[ '-webkit-mask-repeat' ] !== undefined){
		document.getElementsByTagName('html')[0].className += ' cssmasks ';
	}
</script>

