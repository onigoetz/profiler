<?php namespace Onigoetz\Profiler\Panel;

use Illuminate\Routing\Route;
use Onigoetz\Profiler\Panel;
use Onigoetz\Profiler\PanelTitle;
use Session;
use View;

class Router extends Panel
{
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

        return new PanelTitle('Routes', null, $popup);
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
