<?php

namespace Onigoetz\Profiler\Panels;

use View;

class Boomarklets extends Panel
{

    /**
     * Register the panel to the application
     */
    function register()
    {
        // Nothing needed
    }

    /**
     * @return mixed get the data to be serialized
     */
    function getData()
    {
        return array();
    }

    /**
     * @return String the name of the panel, will be used to store the data about the panel
     */
    function getName()
    {
        return 'bookmarklets';
    }

    /**
     * Render the panel
     */
    function render()
    {
        return View::make('profiler::panels/bookmarklets');
    }

    function renderTitle()
    {
        return new PanelTitle('Bookmarklets');
    }
}
