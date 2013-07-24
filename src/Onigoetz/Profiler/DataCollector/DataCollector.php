<?php namespace Onigoetz\Profiler\DataCollector;

abstract class DataCollector {

    /**
     * Provides a list of panels that are provided
     *
     * @return array<String>
     */
    abstract public function provides();

    /**
     * Returns the data
     *
     * @return array
     */
    abstract public function getData();

    /**
     * Register the Collector
     */
    public function register(){

    }

    /**
     * Boot the Collector
     */
    public function boot()
    {

    }
}
