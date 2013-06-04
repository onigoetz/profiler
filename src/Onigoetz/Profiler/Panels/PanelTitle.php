<?php

namespace Onigoetz\Profiler\Panels;


class PanelTitle
{

    /**
     * @var String the title to show
     */
    public $title;

    /**
     * @var Array key value pairs of quick informations
     */
    public $popup;

    /**
     * @var String path to the icon
     */
    public $icon;

    /**
     * @param String $title
     * @param String $icon
     * @param Array $popup
     */
    public function __construct($title, $icon = null, $popup = array())
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->popup = $popup;
    }
}
