<?php namespace Onigoetz\Profiler;

use Illuminate\Support\Facades\Facade;

class Stopwatch extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'stopwatch';
    }

}
