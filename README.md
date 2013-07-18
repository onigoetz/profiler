# Laravel Profiler
Next Generation PHP Profiler for Laravel

![Closed version of the profiler](https://raw.github.com/onigoetz/profiler/master/screenshots/closed.png)

[More screenshots](https://github.com/onigoetz/profiler/tree/master/screenshots "screenshots on github")

## Installation

__this package is currently in development, use it at your own risk !!!__

There are two ways to install this profiler

### Require

Add this dependency to `composer.json` with this command:
`composer require onigoetz/profiler:dev-master`

in `app/config/app.php`

- Add `'Onigoetz\Profiler\ProfilerServiceProvider'` to your providers
- Add `'Stopwatch' => 'Onigoetz\Profiler\Stopwatch'` to your aliases

Then do `./artisan asset:publish onigoetz/profiler` to publish the javascript/css files

### Require-dev (only on development machine)

Add this dependency to `composer.json` with this command:
`composer require-dev onigoetz/profiler:dev-master`

In `app/config/app.php` add `'Stopwatch' => 'Onigoetz\Profiler\Stopwatch'` to your aliases.

At the end of `app/start/global.php` add:

```php
if (class_exists("Onigoetz\\Profiler\\ProfilerServiceProvider")) {
    $provider = new Onigoetz\Profiler\ProfilerServiceProvider(app());
    $app->register($provider);
    $provider->boot();
    $provider->booting();
    $provider->booted();
    $provider->start_router_dispatch();
}
```

This way is not recommended as it means that each call to stopwatch has to be wrapped in a `if(class_exists...)`


## Configuration
By default, the profiler will run only in environment that are not "production"

You can override all default values by doing `./artisan config:publish onigoetz/profiler` and editing the `profiler.php` file.

### Options

- `enabled` A simple boolean to enable the profiler or not.
- `assets_auto` If set to true (default) it will include its assets itself, you can disable this to add the assets to your own build process
- `panels` An array of classes that extend `Onigoetz\Profiler\Panel` you can add your own panels and reorder them.
- `slow_query` Threshold in milliseconds after which it is considered

## Panels
All panels are work in progress for the moment, many changes may evolve

### Time
This panel provides a way to watch for events in a graphical way.

You can profile anything anywhere in your code by using the `Stopwatch` facade.

It's a facade for the [Stopwatch Symfony component](http://symfony.com/doc/current/components/stopwatch.html)
so you don't have to initalize it to use it

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

## Why a new profiler ?
Yes, I know, there are a lot of profilers out there. But for my needs I wanted a profiler that doesn't take a lot of place on the screen and quickly gives useful informations about the application.

## Inspiration
This Profiler was created and improved in a few years and is inspired from

* PHP Quick Profiler
* Symfony web profiler bundle
* Some other small improvements from other profilers I don't remember

It is currently in a complete rewrite to be extensible and configurable.


## How it works
Each panel is a class that has some methods to do it's stuff

* `$data` 	All data must be stored here, so we can serialize the class easily
* `register()` called on `App::before()` here you can register some classes or events
* `getData()` retrieve the data and store in `$this->data`
* `getName()` return a string with the name, will be used as an id and class in HTML
* `render()` return a `View` with the rendered panel
* `renderTitle()` return a `PanelTitle` object with the title properties


## //TODO
* Save the profiling informations to a file to be able to show it again
* Create some kind of live panel where it shows all requests that have been made, the idea is to run it in development only
* Handle redirects -> show a link to open the last run in a popup
* Manage with the laravel community to Add DataCollectors like in Symfony to be able to profile Laravel more accurately
