<?php

return array(

    /*
	|--------------------------------------------------------------------------
	| Enable Profiler
	|--------------------------------------------------------------------------
	|
	| Is the profiler enabled ?
	|
	*/

    'enabled' => true,

    /*
	|--------------------------------------------------------------------------
	| Panels
	|--------------------------------------------------------------------------
	|
	| List of classes that are panels
	|
	*/

    'panels' => array(
        'Onigoetz\Profiler\Panel\Time',
        'Onigoetz\Profiler\Panel\Database',
        'Onigoetz\Profiler\Panel\Router',
        'Onigoetz\Profiler\Panel\Variables',
        'Onigoetz\Profiler\Panel\Monolog',
        'Onigoetz\Profiler\Panel\Files',
        'Onigoetz\Profiler\Panel\Boomarklets'
    ),

    /*
    |--------------------------------------------------------------------------
    | Loglevel
    |--------------------------------------------------------------------------
    |
    | Loglevel to show in the panel
    |
    */

    'loglevel' => 'DEBUG',


    /*
    |--------------------------------------------------------------------------
    | Slow Queries
    |--------------------------------------------------------------------------
    |
    | Time in milliseconds after which a query is considered slow.
    | Set to 0 to disable
    |
    */

    'slow_query' => 100,

);
