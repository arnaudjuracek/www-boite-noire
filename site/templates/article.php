<?php snippet('header') ?>

	<?php snippet('menu') ?>
	<main role="main">
		<?php $article = $page;	?>
		<div class="articles-container">
			<article data-type="<?php echo $article->io() ?>">
				<header>
					<h1>
						<a href="<?php echo $article->url() ?>">
							<?php echo html($article->title()) ?>
						</a>
					</h1>

					<div class="meta">
						<?php $io = $article->io()->html(); ?>
						<div class="io"><a href="<?php echo url('io:' . urlencode($io)) ?>">&mdash;&ensp;<?php echo $io ?></a></div>
						<time datetime="<?php echo $article->date('c') ?>">
							<?php echo $article->date('d.m.Y'); ?>
						</time>

						<?php if($article->tags() != ''): ?>
							<ol class="tags">
								<?php
									$tags = str::split($article->tags());
									sort($tags);
								?>
								<?php foreach($tags as $tag): ?>
									<li><a href="<?php echo url('tag:' . urlencode($tag)) ?>">#<?php echo $tag; ?></a></li>
								<?php endforeach ?>
							</ol>
						<?php endif ?>
						<?php if($user = site()->user() and $user->hasPanelAccess()) : ?>
							<a href="<?php echo getPanelURL( $article, 'show') ?>" class="edit">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
							</a>
						<?php endif; ?>
					</div>
				</header>
				<div class="content">
					<div class="text">
						<?php echo kirbytext($article->text()) ?>
					</div>
					<div class="gallery">
						<?php
							$filenames = $article->attachments()->split(',');

							if(count($filenames)<2) $filenames = array_pad($filenames, 2, '');
							$files = call_user_func_array(array($article->files(), 'find'), $filenames);

							foreach($files as $image){
								echo kirbytag(array(
									'image'  		=> $image->filename(),
									'taille'		=> 'image grid',
									'thumbwidth'  	=> 1200,
									'originalPage'	=> $article,
									'alt'			=> $image->caption(),
								));
							}
						?>
					</div>
				</div>
			</article>
		</div>

	</main>

  <?php snippet('footer') ?>