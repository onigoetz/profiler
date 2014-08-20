# Laravel Profiler

> ## __DISCONTINUED__
>
> This project is no longer maintained and I won't provide support for it.
>
> I recommend to use [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) or [PHP Debugbar](http://phpdebugbar.com/)

## Installation

Add this dependency to `composer.json` with this command:
`composer require-dev onigoetz/profiler:dev-master`

And add this in your `configuration/app.php` file. This will allow the Profiler to only load locally and will not clutter your production build.

````php
    'providers' => array(
        'Onigoetz\Profiler\Support\Laravel\ProfilerServiceProvider',
        ...
    ),
    'aliases' => array(
        ...
        'Stopwatch' => 'Onigoetz\Profiler\Stopwatch'
        ...
    )
```

Then do `./artisan asset:publish onigoetz/profiler` to publish the javascript/css files

## Configuration
By default, the profiler will run only in environment that are not "production"

You can override all default values by doing `./artisan config:publish onigoetz/profiler` and editing the `profiler.php` file.

### Options

- `environments` An array of environments on which the profiler may be shown
- `assets_auto` If set to true (default) it will include its assets itself, you can disable this to add the assets to your own build process
- `panels` An array of classes that extend `Onigoetz\Profiler\Panel` you can add your own panels and reorder them.
- `slow_query` Threshold in milliseconds after which it is considered slow

## Panels
All panels are work in progress for the moment, many changes may happen

### Time
This panel provides a way to watch for events in a graphical way.

You can profile anything anywhere in your code by using the `Stopwatch` facade.

It's a facade for a stopwatch heavily inspired from [Stopwatch Symfony component](http://symfony.com/doc/current/components/stopwatch.html), the difference is that mine doesn't support sections
As any Laravel Facade you don't have to initialize it, just use it

__Example:__

```php
Stopwatch::start('stuff to benchmark');

//do your stuff

Stopwatch::stop('stuff to benchmark');
```

### Database
Provide a list of executed queries and their bindings.
Also checks for duplicated queries, based on raw SQL without bindings, small but useful tool to track down which query could be improved

### Router
List of declared routes with some more informations ( route name, filter, hostname, action …)
Also highlights the current route.

(The same informations as the `./artisan routes` + highlighted current route)

### Variables
Dump of `$_GET`, `$_POST`, `$_FILES`, `$_COOKIE`, Session, `$_SERVER` and `$_ENV` variables

### Log
Registers a new log handler to output the logs from the current run

### Files
List of loaded files and their size

### Bookmarklets
A list of useful bookmarklets + loaded scripts on the current page

## How it works
Each panel is a class that has some methods to do it's stuff

* `$data` 	All data must be stored here, so we can serialize the class easily
* `register()` called on `App::before()` here you can register some classes or events
* `getData()` retrieve the data and store in `$this->data`
* `getName()` return a string with the name, will be used as an id and class in HTML
* `render()` return a `View` with the rendered panel
* `renderTitle()` return a `PanelTitle` object with the title properties
