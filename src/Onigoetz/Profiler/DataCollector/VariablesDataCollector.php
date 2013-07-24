<?php namespace Onigoetz\Profiler\DataCollector;

use Onigoetz\Profiler\DataCollector\DataCollector;

class VariablesDataCollector extends DataCollector
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
        return array(
            'variables' => array(
                'GET Data' => $_GET,
                'POST Data' => $_POST,
                'Files' => $_FILES,
                'Cookies' => $_COOKIE,
                'Server/Request Data' => $_SERVER,
                'Environment Variables' => $_ENV
            )
        );
    }
}
