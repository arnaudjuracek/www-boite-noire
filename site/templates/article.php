<?php snippet('header') ?>
<?php snippet('menu') ?>

	<main role="main">
		<?php $article = $page ?>
		<article>
			<header>
				<h1>
					<a href="<?php echo $article->url() ?>">
						<?php echo html($article->title()) ?>
					</a>
				</h1>

				<div class="meta">
					<time datetime="<?php echo $article->date('c') ?>">
						<?php echo $article->date('F dS, Y'); ?>
					</time>

					<?php if($article->tags() != ''): ?> |
						<ul class="tags">
							<?php foreach(str::split($article->tags()) as $tag): ?>
								<li><a href="<?php echo url('tag:' . urlencode($tag)) ?>">#<?php echo $tag; ?></a></li>
							<?php endforeach ?>
						</ul>
					<?php endif ?>
				</div>
			</header>
			<div class="content">
				<?php echo kirbytext($article->text()) ?>
				<div class="gallery">
					<?php
						$filenames = $article->attachments()->split(',');

						if(count($filenames)<2) $filenames = array_pad($filenames, 2, '');
						$files = call_user_func_array(array($article->files(), 'find'), $filenames);

						// Use the file collection
						foreach($files as $image){
							echo kirbytag(array(
								'image'  		=> $image->filename(),
								'taille'		=> 'image grid',
								'thumbwidth'  	=> 1200,
								'originalPage'	=> $article
							));
						}
					?>
				</div>
			</div>
		</article>
	</main>

  <?php snippet('footer') ?>