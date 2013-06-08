<?php namespace Onigoetz\Profiler;

use App;
use Config;
use View;

class Toolbar
{

    protected $panels;

    public function __construct()
    {

        $panels = Config::get('profiler::profiler.panels');

        $this->panels = array();
        foreach ($panels as $panel) {
            $this->panels[] = App::make($panel);
        }

        App::before(array($this, 'register'));
    }

    public function register()
    {
        $this->callPanels('register');
    }

    public function generateData()
    {
        $this->callPanels('getData');
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

    protected function callPanels($method)
    {
        foreach ($this->panels as $panel) {
            $panel->{$method}();
        }
    }
}
