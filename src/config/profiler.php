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
	| Environments Blacklist
	|--------------------------------------------------------------------------
	|
	| The profiler must NOT run in these environments
	|
	*/

    'environments_blacklist' => array(
        'production',
        'prod'
    ),

    /*
    |--------------------------------------------------------------------------
    | Include assets automatically
    |--------------------------------------------------------------------------
    |
    | Should the profiler include its assets automatically ?
    |
    */

    'assets_auto' => true,

    /*
	|--------------------------------------------------------------------------
	| Panels
	|--------------------------------------------------------------------------
	|
	| List of panels to load
	|
	*/

    'panels' => array(
        'time',
        'database',
        'router',
        'variables',
        'monolog',
        'files',
        'bookmarklets'
    ),

    /*
    |--------------------------------------------------------------------------
    | Storage
    |--------------------------------------------------------------------------
    |
    | How to store the panels data
    |
    */

    'storage' => array(
        'driver' => 'file',
    ),

    /*
    |--------------------------------------------------------------------------
    | Loglevel
    |--------------------------------------------------------------------------
    |
    | Minimum Loglevel to show in the panel
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
