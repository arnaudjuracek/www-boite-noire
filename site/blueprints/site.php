<?php if(!defined('KIRBY')) exit ?>

title: Site
pages: true
fields:
  title:
    label: Title
    type:  text
  author:
    label: Author
    type:  text
  description:
    label: Description
    type:  textarea
  keywords:
    label: Keywords
    type:  tags
  htmllang:
    label: Code de langue
    type:  text
  ogurl:
    label: (Facebook) URL de base
    type:  text
  ogimage:
    label: (Facebook) URL de l'image d'aperçu
    type:  text
  ogsite_name:
    label: (Facebook) Nom du site et description en une phrase
    type: text

  copyright:
    label: Copyright
    type:  textarea