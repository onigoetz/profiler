<?php namespace Onigoetz\Profiler\Support\Laravel\DataCollector;

use Monolog\Handler\TestHandler;
use Onigoetz\Profiler\DataCollector\DataCollector;

class MonologDataCollector extends DataCollector {

    protected $handler;

    public function register()
    {
        $this->handler = new TestHandler;
        app('log')->getMonolog()->pushHandler($this->handler);
    }

    /**
     * Register the panel to the application
     */
    function provides()
    {
        return array('monolog');
    }

    /**
     * @return mixed get the data to be serialized
     */
    function getData()
    {
        return array(
            'monolog' => array('logs' =>  $this->handler->getRecords(), 'logger' => app('log')->getMonolog())
        );
    }
}
