<?php

/*

---------------------------------------
License Setup
---------------------------------------

Please add your license key, which you've received
via email after purchasing Kirby on http://getkirby.com/buy

It is not permitted to run a public website without a
valid license key. Please read the End User License Agreement
for more information: http://getkirby.com/license

*/

c::set('license', 'put your license key here');
c::set('debug', true);

/*

---------------------------------------
Kirby Configuration
---------------------------------------

By default you don't have to configure anything to
make Kirby work. For more fine-grained configuration
of the system, please check out http://getkirby.com/docs/advanced/options

*/

c::set('multisizes', true);
c::set('lazyloadimages', true);
c::set('lowResPreview', true);


c::set('languages', array(
  array(
	'code'    => 'fr',
	'name'    => 'French',
	'default' => true,
	'locale'  => 'fr_FR',
	'url'     => '/',
  ),
/*
  array(
	'code'    => 'en',
	'name'    => 'English',
	'locale'  => 'en_US',
	'url'     => '/en',
  ),
*/
));


c::set('smartypants', true);
c::set('panel.stylesheet', 'assets/css/custompanel.css');
c::set('routes', array(
	array(
		'pattern' => 'sitemap.xml',
		'action'  => function() {
			return site()->visit('xmlsitemap');
		}
	),
	array(
		'pattern' => 'sitemap',
		'action'  => function() {
			return go('sitemap.xml');
		}
	),

	array(
		'pattern' => md5(site()->url()) . '/(:any)/(:any)/(:any)',
		'action'  => function($page, $blueprint, $title){
			return create_post($page, $blueprint, $title, $_POST);
		},
		'method' => 'POST'
	),

	array(
		'pattern' => 'md5',
		'action'  => function(){
			echo site()->url() . '<br>';
			echo md5(site()->url());
		},
	),
));