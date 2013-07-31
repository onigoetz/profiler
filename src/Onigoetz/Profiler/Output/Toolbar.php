<?php namespace Onigoetz\Profiler\Output;

use Onigoetz\Profiler\DataContainer;
use Onigoetz\Profiler\Panels;
use Onigoetz\Profiler\Tools\Config;
use Onigoetz\Profiler\Tools\View;

class Toolbar implements OutputInterface
{

    protected $panels;
    protected $data;

    public function __construct(DataContainer $data)
    {
        $this->data = $data;

        $collectors = $this->data->getCollectorProvides();

        $config_panels = Config::get('panels');

        include __DIR__ . '/../../../panels.php';

        $this->panels = array();
        foreach ($config_panels as $panel) {
            if (in_array($panel, $collectors)) {
                $this->panels[$panel] = Panels::$panels[$panel];
            }
        }
    }

    /**
     * @return string
     */
    public function render()
    {
        $data = $this->data->getData();

        $titles = function ($panels) use ($data) {
            $panel_titles = array();

            foreach ($panels as $panel) {
                $panel_titles[$panel['name']] = $panel['title']($data, array_key_exists('icon', $panel) ? $panel['icon'] : null);
            }

            return $panel_titles;
        };

        return View::render(
            __DIR__ . '/../../../views/toolbar.php',
            array('panels' => $this->panels, 'panel_titles' => $titles, 'data' => $data)
        );
    }
}
