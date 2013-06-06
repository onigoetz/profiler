# Laravel Profiler
Next Generation PHP Profiler for Laravel

## Installation

Add this dependency to composer with this command: 
`composer onigoetz/profiler:dev-master`

Add `Onigoetz\Profiler\ProfilerServiceProvider` to your providers in `app/config/app.php`

Then do `./artisan asset:publish onigoetz/profiler` to publish the javascript/css files

## Configuration
For the moment, there are no options to configure it.

By default, the profiler will run only in environment that are not "production"


## Why a new profiler ?
Yes, I know, there are a lot of profilers out there. But for my needs I wanted a profiler that doesn't take a lot of place on the screen and gives really useful informations about the application

## Inspiration
This Profiler was created and improved in a few years and is inspired from

* PHP Quick Profiler
* Symfony web profiler bundle
* Some other small improvements from other profilers I don't remember

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
* Manage with The laravel community to Add DataCollectors like in Symfony to be able to profile Laravel more accurately
