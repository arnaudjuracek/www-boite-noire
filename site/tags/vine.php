<?php
kirbytext::$tags['vine'] = array(
  'attr' => array(
    'size'
  ),
  'html' => function($tag) {
    $vineURL     = $tag->attr('vine');
    $size        = $tag->attr('size', '300');

    return '<div class="embed-responsive embed-responsive-4by3"><iframe class="embed-responsive-item" src="' . $vineURL . '/' . 'embed/simple" frameborder="0"></iframe><script async src="https://platform.vine.co/static/scripts/embed.js"></script></div>';
  }
);
?>