<?php namespace Onigoetz\Profiler\Support\Laravel\DataCollector;

use Session;

class VariablesDataCollector extends \Onigoetz\Profiler\DataCollector\VariablesDataCollector
{
    public function provides()
    {
        return array('variables');
    }

    /**
     * @return mixed get the data to be serialized
     */
    public function getData()
    {
        $data = parent::getData();

        $data['variables']['Session'] = Session::all();

        return $data;
    }
}
