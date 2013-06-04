<?php

namespace Onigoetz\Profiler;


use App;
use View;

class Toolbar
{

    protected $panels;

    public function __construct()
    {

        //TODO :: load conditionally
        $this->panels[] = new Panels\Time;
        $this->panels[] = new Panels\Monolog;
        $this->panels[] = new Panels\Files;
        $this->panels[] = new Panels\Database;
        $this->panels[] = new Panels\Boomarklets;


        App::before(array($this, 'register'));
    }

    public function register()
    {
        foreach ($this->panels as $panel) {
            $panel->register();
        }
    }

    public function render()
    {
        $titles = function ($panels) {
            $panel_titles = array();

            foreach ($panels as $panel) {
                $panel_titles[$panel->getName()] = $panel->renderTitle();
            }

            return $panel_titles;
        };

        return View::make('profiler::toolbar', array('panels' => $this->panels, 'panel_titles' => $titles));
    }
}
