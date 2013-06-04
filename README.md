# Laravel Profiler
Next Generation PHP Profiler for Laravel

## Why a new profiler ?
Yes, I know, there are a lot of profilers out there. But for my needs I wanted a profiler that doesn't take a lot of place on the screen and gives really useful informations about the application

## Inspiration
This Profiler was created and improved in a few years and is inspired from

* PHP Quick Profiler
* Symfony web profiler bundle
* Some other small improvements from other profilers I don't remember

## How does it work
Each panel is a class that has some methods to do it's stuff

* `$data` 	All data must be stored here, so we can serialize the class easily
* `register()` called on `App::before()` here you can register some classes or events
* `getData()` retrieve the data and store in `$this->data`
* `getName()` return a string with the name, will be used as an id and class in HTML
* `render()` return a `View` with the rendered panel
* `renderTitle()` return a `PanelTitle` object with the title properties



## TODO

* Save the profiling informations to a file to be able to show it again
* Handle redirects -> show a link to open the last run in a popup
* Manage with Taylor to Add DataCollectors like in Symfony to be able to profile Laravel deeply