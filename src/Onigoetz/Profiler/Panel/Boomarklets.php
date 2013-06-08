<?php

namespace Onigoetz\Profiler\Panel;

use Onigoetz\Profiler\Panel;
use Onigoetz\Profiler\PanelTitle;
use View;

class Boomarklets extends Panel
{

    /**
     * @return mixed get the data to be serialized
     */
    function getData()
    {
        return null;
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
