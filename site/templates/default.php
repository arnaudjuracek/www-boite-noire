<?php snippet('header') ?>

	<?php snippet('menu') ?>
	<main role="main">

		<?php
			if(param('tag')){
				$tag = urldecode(param('tag'));
				$articles = $pages->find('blog')
								->children()
								->visible()
								->filterBy('tags', $tag, ',')
								->sortBy('date', 'desc', 'time', 'desc');
			}else if(param('invisible') && $user = site()->user() && $user->hasPanelAccess()){
				$articles = $pages->find('blog')->children()->sortBy('date', 'desc', 'time', 'desc');
			}else{
				$articles = $pages->find('blog')->children()->visible()->sortBy('date', 'desc', 'time', 'desc');
			}
		?>

		<div class="articles-container">
			<?php foreach($articles as $article):?>
				<article data-type="<?php echo $article->io() ?>">
					<header>
						<h1>
							<a href="<?php echo $article->url() ?>">
								<?php echo html($article->title()) ?>
							</a>
						</h1>

						<div class="meta">
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
						<?php echo kirbytext($article->text()) ?>
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
			<?php endforeach ?>
		</div>

	</main>

  <?php snippet('footer') ?>