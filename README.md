# Laravel Profiler
Next Generation PHP Profiler for Laravel

![Closed version of the profiler](https://raw.github.com/onigoetz/profiler/master/screenshots/closed.png)

[More screenshots](https://github.com/onigoetz/profiler/tree/master/screenshots "screenshots on github")

## Installation

__this package is currently in development, use it at your own risk !!!__

Add this dependency to composer with this command:
`composer require onigoetz/profiler:dev-master`

Add `Onigoetz\Profiler\ProfilerServiceProvider` to your providers in `app/config/app.php`

Then do `./artisan asset:publish onigoetz/profiler` to publish the javascript/css files

## Configuration
By default, the profiler will run only in environment that are not "production"

You can override all default values by doing `./artisan config:publish onigoetz/profiler` and editing the `profiler.php` file.

### Options

- `enabled` A simple boolean to enable the profiler or not.
- `panels` An array of classes that extend `Onigoetz\Profiler\Panel` you can add your own panels and reorder them.

## Panels
All panels are work in progress for the moment, many changes may evolve

### Time
The idea behind this panel is to make a timeline like it was done in the symfony profiler.

The only thing this panel provides is the time the script has run.

### Database
Provide a list of executed queries and their bindings.
Also checks for duplicated queries, based on raw SQL without bindings, small but useful tool to track down which query could be improved

//TODO highlight slow queries, configure the slow query threshold

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
