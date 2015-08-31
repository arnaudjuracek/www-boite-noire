<?php ///////////////////////////////////////////////////////
// ----------------------------------------------------------
// Sitemap settings
// ----------------------------------------------------------
/////////////////////////////////////////////////////////////

// Ignore pages
$ignore = array('base', 'sitemap', 'search', 'feed', 'error', 'drafts');
$ignoreFolder = array('liste-des-intervenants/');

// Set header
header('Content-type: text/xml; charset="utf-8"');
echo '<?xml version="1.0" encoding="utf-8"?>';

// Set language codes in seperate array ($lang_codes)
$i = 0; foreach($site->languages() as $language):
	$lang_codes[$i]['code'] = $language->code();
	$lang_codes[$i]['locale'] = $language->locale();
$i++; endforeach;

////////////////////////////////////////////////////////// ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"<?php if(c::get('images.in.sitemap')): ?> xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"<?php endif; ?>>
<?php foreach($pages->index()->filter(function($page) {
		if( str::contains($page->uri(), 'xx-') || str::contains($page->uri(), 'liste-des-intervenants/') ) {
			return false;
		}
		return true;
	}) as $page): ?>
<?php if(in_array($page->slug(), $ignore)) continue ?>
	<?php foreach($site->languages() as $language): ?>
		<?php if(isset($page->inventory()['content'][$language->code()])): ?>
			<url>
				<loc><?php echo html($page->url($language->code())); ?></loc>
				<?php /* if($page->hasImages()): ?>
					<?php foreach($page->images() as $image): ?>
						<image:image>
							<image:loc><?php echo $image->url() ?></image:loc>
						</image:image>
					<?php endforeach; ?>
				<?php endif; */ ?>
				<lastmod><?php echo $page->modified('c'); ?></lastmod>
				<priority><?php echo ($page->isHomePage()) ? 1 : number_format(0.5/$page->depth(), 1); ?></priority>
				<?php for($c = 0; $c < count($lang_codes); $c++): // Call all languages from $lang_codes array (defined above) ?>
					<?php if($site->languages()->count() > 1 && count($page->inventory()['content']) > 1 && isset($page->inventory()['content'][$lang_codes[$c]['code']])): ?>
						<xhtml:link rel="alternate" hreflang="<?php echo $lang_codes[$c]['locale']; ?>" href="<?php echo $page->url($lang_codes[$c]['code']); ?>"/>
					<?php endif; ?>
				<?php endfor; ?>
			</url>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endforeach; ?>
</urlset>
