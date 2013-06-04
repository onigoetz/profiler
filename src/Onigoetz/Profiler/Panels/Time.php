<?php
namespace Onigoetz\Profiler\Panels;


use Onigoetz\Profiler\Utils;
use View;

class Time extends Panel
{
    protected $icon = '';


    /**
     * Register the panel to the application
     */
    function register()
    {
        //Get the real start time
        if (defined('LARAVEL_START')){
            $this->data['appStartTime'] = LARAVEL_START;
        } else {
            $this->data['appStartTime'] = microtime(true);
        }
    }

    /**
     * @return mixed get the data to be serialized
     */
    function getData()
    {
        $this->data['totalTime'] = microtime(true) - $this->data['appStartTime'];

        $this->data['popup'] = array(
            'Load time' => Utils::getReadableTime($this->data['totalTime'] * 1000),
            'Max time' => Utils::getReadableTime(ini_get('max_execution_time') * 1000)
        );

        return $this->data;
    }

    /**
     * @return String the name of the panel, will be used to store the data about the panel
     */
    function getName()
    {
        return 'time';
    }

    /**
     * Render the panel
     */
    function render()
    {
        $this->getData();
        return View::make('profiler::panels/time', array());
    }

    function renderTitle()
    {
        return new PanelTitle(Utils::getReadableTime($this->data['totalTime'] * 1000), $this->icon, $this->data['popup']);
    }
}
