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
    default: today
    width:  1/4
    format: DD/MM/YYYY
  time:
    label:  Time
    type:   time
    default: now
    width:  1/4
  tags:
    label: Tags
    type:  tags
    width: 3/4
  io:
    label: IO
    type: radio
    width: 1/4
    default: output
    options:
      input: input
      output: output

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
