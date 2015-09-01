<?php if(!defined('KIRBY')) exit ?>

title: Article
pages: false
files: true
 fields:
      caption:
        label: Alt
        type: text
fields:

  articleMeta:
    label: Article Meta
    type: headline
  title:
    label: Title
    type:  text
    width: 1/2
  date:
    label:  Date
    type:   date
    width:  1/2
    format: MM/DD/YYYY
  tags:
    label: Tags
    type:  tags

  articleContent:
    label: Article Content
    type: headline
  text:
    label: Text
    type:  markdown
    icon:  file-text-o

  attachments:
    label: Gallery
    type: selector
    mode: multiple
    sort: sort
    autoselect: all
    types:
      - all
