<?php namespace Onigoetz\Profiler;

use Onigoetz\Profiler\DataCollector\DataCollector;

class DataContainer {

    /**
     * @var array<DataCollector>
     */
    protected $collectors;

    /**
     * @var array
     */
    protected $data;

    /**
     * Contains DataCollectors
     */
    public function __construct()
    {
        $this->collectors = array();
        $this->data = array();
    }

    /**
     * Register a DataCollector
     *
     * @param DataCollector $collector
     * @return $this
     */
    public function add(DataCollector $collector) {
        $this->collectors[] = $collector;

        return $this;
    }

    /**
     * Call register Event
     */
    public function register()
    {
        $this->callCollectors('register');
    }

    /**
     * Call boot Event
     */
    public function boot()
    {
        $this->callCollectors('boot');
    }

    /**
     * Generate the data
     *
     * @return array
     */
    public function generateData()
    {
        foreach ($this->collectors as $collector) {
            $this->data += $collector->getData();
        }
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * Call a command on the collectors
     *
     * @param string $method
     */
    protected function callCollectors($method)
    {
        foreach ($this->collectors as $collector) {
            $collector->{$method}();
        }
    }

    /**
     * Serializes only what's in data
     *
     * @return array
     */
    public function __sleep(){
        return array('data');
    }
}
