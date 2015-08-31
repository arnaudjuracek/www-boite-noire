<?php
kirbytext::$tags['vine'] = array(
  'attr' => array(
    'size'
  ),
  'html' => function($tag) {
    $vineURL     = $tag->attr('vine');
    $size        = $tag->attr('size', '300');

    return '<iframe src="' . $vineURL . '/' . 'embed/simple" width="' . $size . '" height="' . $size . '" frameborder="0" class="vine-embed"></iframe><script async src="https://platform.vine.co/static/scripts/embed.js"></script>';
  }
);
?>