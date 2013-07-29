<?php namespace Onigoetz\Profiler\Support\Laravel\DataCollector;

use Onigoetz\Profiler\DataCollector\DataCollector;
use Onigoetz\Profiler\Stopwatch;
use Onigoetz\Profiler\Utils;

class TimeDataCollector extends DataCollector {

    public function provides()
    {
        return array('time');
    }

    /**
     * Register the panel to the application
     */
    public function register()
    {
        //Get the real start time
        $this->data['appStartTime'] = (defined('LARAVEL_START'))? LARAVEL_START : microtime(true);
    }

    /**
     * @return mixed get the data to be serialized
     */
    public function getData()
    {
        //this may happen in case of early termination
        if (empty($this->data)) {
            $this->register();
        }

        Stopwatch::stopSection('__application__');

        $this->data['events'] = Stopwatch::getSectionEvents('__application__');

        $this->data['totalTime'] = microtime(true) - $this->data['appStartTime'];

        $this->data['popup'] = array(
            'Load time' => Utils::getReadableTime($this->data['totalTime'] * 1000),
            'Max time' => Utils::getReadableTime(ini_get('max_execution_time') * 1000)
        );

        return array('time' => $this->data);
    }
}
