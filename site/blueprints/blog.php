<?php if(!defined('KIRBY')) exit ?>

title: Blog
pages: true
  template: article
  sort: flip
  num: date
fields:
  title:
    label: Title
    type:  text