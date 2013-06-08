<?php namespace Onigoetz\Profiler;

abstract class Panel
{
    protected $data;
    protected $icon;

    /**
     * Register the panel to the application
     */
    function register(){

    }

    /**
     * @return mixed get the data to be serialized
     */
    abstract function getData();

    /**
     * @return String the name of the panel, will be used to store the data about the panel
     */
    abstract function getName();

    /**
     * Render the panel
     *
     * @return \Illuminate\View\View The rendered panel
     */
    abstract function render();

    /**
     * The title to place in the toolbar
     *
     * @return PanelTitle The object to render the title
     */
    abstract function renderTitle();

    /**
     * Serializes only what's in data
     *
     * @return array
     */
    public function __sleep(){
        return array('data');
    }
}
