<?php namespace Onigoetz\Profiler;

use Onigoetz\Profiler\DataCollector\DataCollector;
use Onigoetz\Profiler\Storage\StorageInterface;

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
     * @var StorageInterface
     */
    protected $storage;

    /**
     * Contains DataCollectors
     */
    public function __construct()
    {
        $this->collectors = array();
        $this->data = array();

        $this->uniqueId = microtime(true) . '_' . mt_rand();
    }

    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    /**
     * @return array
     */
    public function getCollectorProvides()
    {
        $provides = array();
        foreach ($this->collectors as $collector) {
            $provides = array_merge($provides, $collector->provides());
        }

        return $provides;
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
     * Set the storage system
     *
     * @param StorageInterface $storage
     * @return $this
     */
    public function setStorage(StorageInterface $storage) {
        $this->storage = $storage;

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

    /**
     * Get the generated data
     *
     * @return array
     */
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
     * Save the data with the storage
     */
    public function saveData()
    {
        if ($this->storage == null) {
            return;
        }

        $this->storage->put($this);
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
