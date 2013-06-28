<?php namespace Onigoetz\Profiler\Panel;

use Illuminate\Routing\Route;
use Onigoetz\Profiler\Panel;
use Onigoetz\Profiler\PanelTitle;
use Session;
use View;

class Router extends Panel
{
    protected $icon = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAHYSURBVDjLlVLPS1RxHJynpVu7KEn0Vt+2l6IO5qGCIsIwCPwD6hTUaSk6REoUHeoQ0qVAMrp0COpY0SUIPVRgSl7ScCUTst6zIoqg0y7lvpnPt8MWKuuu29w+hxnmx8dzzmE5+l7mxk1u/a3Dd/ejDjSsII/m3vjJ9MF0yt93ZuTkdD0CnnMO/WOnmsxsJp3yd2zfvA3mHOa+zuHTjy/zojrvHX1YqunAZE9MlpUcZAaZQBNIZUg9XdPBP5wePuEO7eyGQXg29QL3jz3y1oqwbvkhCuYEOQMp/HeJohCbICMUVwr0DvZcOnK9u7GmQNmBQLJCgORxkneqRmAs0BFmDi0bW9E72PPda/BikwWi0OEHkNR14MrewsTAZF+lAAWZEH6LUCwUkUlntrS1tiG5IYlEc6LcjYjSYuncngtdhakbM5dXlhgTNEMYLqB9q49MKgsPjTBXntVgkDNIgmI1VY2Q7QzgJ9rx++ci3ofziBYiiELQEUAyhB/D29M3Zy+uIkDIhGYvgeKvIkbHxz6Tevzq6ut+ANh9fldetMn80OzZVVdgLFjBQ0tpEz68jcB4ifx3pQeictVXIEETnBPCKMLEwBIZAPJD767V/ETGwsjzYYiC6vzEP9asLo3SGuQvAAAAAElFTkSuQmCC';

    /**
     * @return mixed get the data to be serialized
     */
    function getData()
    {
        $this->data = array(
            'currentRoute' => \Route::getCurrentRoute(),
        );

        $routes = \Route::getRoutes()->all();

        $results = array();
        foreach ($routes as $name => $route) {
            $results[] = $this->getRouteInformation($name, $route);
        }

        $this->data = array('routes' => $results);

        return $this->data;
    }

    /**
     * @return String the name of the panel, will be used to store the data about the panel
     */
    function getName()
    {
        return 'router';
    }

    /**
     * Render the panel
     */
    function render()
    {
        return View::make('profiler::panels/router', array('routes' => $this->data));
    }

    function renderTitle()
    {
        $popup = array(
            'Routes' => count($this->data['routes'])
        );

        return new PanelTitle('Routes', $this->icon, $popup);
    }

    /**
     * Get the route information for a given route.
     *
     * @param  string $name
     * @param  Route $route
     * @return array
     */
    protected function getRouteInformation($name, Route $route)
    {
        $uri = head($route->getMethods()) . ' ' . $route->getPath();

        $action = $route->getAction() ? : 'Closure';

        return array(
            'current' => ($this->data['currentRoute'] == $route),
            'host' => $route->getHost(),
            'uri' => $uri,
            'name' => $this->getRouteName($name),
            'action' => $action,
            'before' => $this->getBeforeFilters($route),
            'after' => $this->getAfterFilters($route)
        );
    }

    /**
     * Get the route name for the given name.
     *
     * @param  string $name
     * @return string
     */
    protected function getRouteName($name)
    {
        return str_contains($name, ' ') ? '' : $name;
    }

    /**
     * Get before filters
     *
     * @param  Route $route
     * @return string
     */
    protected function getBeforeFilters($route)
    {
        return implode(', ', $route->getBeforeFilters());
    }

    /**
     * Get after filters
     *
     * @param  Route $route
     * @return string
     */
    protected function getAfterFilters($route)
    {
        return implode(', ', $route->getAfterFilters());
    }
}
