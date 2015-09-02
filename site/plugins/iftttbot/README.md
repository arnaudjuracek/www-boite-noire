# IFTTT BOT plugin

A plugin for [Kirby CMS](http://getkirby.com) to automatically post from a make request. Designed for IFTTT's Make channel.

## Installation
### Kirby side
* Put the `iftttbot` folder in `/site/plugins/`
* In `config.php`, create a new route (http://getkirby.com/docs/advanced/routing) :
```
c::set('routes', array(
  array(
    'pattern' => 'iftttbot/(:any)/(:any)',
    'action'  => function($page, $blueprint){
        return create_post($page, $blueprint, $_POST);
      },
    'method' => 'POST'
  ),
 ));
```

### IFTTT side
* Select whatever trigger you want to use.
* Select (and activate) the Action Channel "Make".
* Select the "Make a web request" action.
* 


## Usage

## Security

## Authors
Louis Eveillard & Arnaud Juracek

## Changelog

* **1.0.0** Initial release
