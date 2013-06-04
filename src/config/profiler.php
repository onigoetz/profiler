<?php

return array(

    /*
	|--------------------------------------------------------------------------
	| Enabled panels
	|--------------------------------------------------------------------------
	|
	| This option controls if each panel can be shown or not.
	|
	*/

    'panels' => array(

        /*
        |--------------------------------------------------------------------------
        | Time
        |--------------------------------------------------------------------------
        |
        | How long does the controller take ? How long does it take to bootstrap
        | Laravel ? With this panel you know it !
        |
        */

        'time' => true,


        /*
        |--------------------------------------------------------------------------
        | Database
        |--------------------------------------------------------------------------
        |
        | Precise informations about each queries to the database.
        | You can also configure too long queries to automatically call "EXPLAIN"
        |
        */

        'database' => true,


        /*
        |--------------------------------------------------------------------------
        | Memory
        |--------------------------------------------------------------------------
        |
        | Gives information about memory usage at different steps
        | of the application.
        |
        */

        'memory' => true,


        /*
        |--------------------------------------------------------------------------
        | Files
        |--------------------------------------------------------------------------
        |
        | List the loaded files in their correct order and their size
        |
        */

        'files' => true,


        /*
        |--------------------------------------------------------------------------
        | Variables
        |--------------------------------------------------------------------------
        |
        | Provides some general informations about the context
        |
        */

        'variables' => true,


        /*
        |--------------------------------------------------------------------------
        | Bookmarklets
        |--------------------------------------------------------------------------
        |
        | A set of useful bookmarklets for development purposes
        |
        */

        'bookmarklets' => true,


        /*
        |--------------------------------------------------------------------------
        | Log
        |--------------------------------------------------------------------------
        |
        | Display the log
        |
        */
        'log' => true
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
