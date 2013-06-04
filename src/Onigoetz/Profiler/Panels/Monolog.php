<?php

namespace Onigoetz\Profiler\Panels;


use Log;
use Monolog\Handler\TestHandler;
use View;

class Monolog extends Panel
{

    protected $handler;

    protected $data;
    protected $icon = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAD3SURBVDjLY/j//z8DJRhM5Mx/rLLo8Lv/ZBsA0kyRATBDYOzy8vJsIP5fUlLyv6Cg4H92dvb/1NTU/wkJCf8jIyP/BwcH/8fqgkUHSXcFA1UCce7+t/9n7Xn9P2LiPRWyXRDae0+ld8tL8rwQ1HVHpXPTc7jmuLi47IiIiP+BgYH/vby8/js7O/+3sbH5b2Ji8l9XV/e/mpoaaiC2rX/+v3HN0/81q54OUCCWL3v8v3Tp4//Fix+T7wKQZuu8S+THAkgzzAVGRkbZ2tra/1VUVP7Lycn9FxcX/y8kJPSfh4fnPzs7+39mZmbUQARpBGG7oisddA9EAPd/1bRtLxctAAAAAElFTkSuQmCC";

    /**
     * @param mixed $data
     * @return mixed
     */
    function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * Register the panel to the application
     */
    function register()
    {
        $this->handler = new TestHandler;
        Log::getMonolog()->pushHandler($this->handler);
    }

    /**
     * @return mixed get the data to be serialized
     */
    function getData()
    {
        $this->data = $this->handler->getRecords();
        return $this->data;
    }

    /**
     * @return String the name of the panel, will be used to store the data about the panel
     */
    function getName()
    {
        return 'log';
    }

    /**
     * Render the panel
     */
    function render()
    {
        $this->getData();
        return View::make('profiler::panels/monolog', array('logs' => $this->data, 'logger' => Log::getMonolog()));
    }

    function renderTitle()
    {
        return new PanelTitle(count($this->data), $this->icon);
    }
}
