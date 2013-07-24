<?php namespace Onigoetz\Profiler\Support\Laravel\DataCollector;

use Request;
use Onigoetz\Profiler\DataCollector\DataCollector;
use Illuminate\Routing\Route;

class RouterDataCollector extends DataCollector
{
    public function provides()
    {
        return array('router');
    }

    /**
     * @return mixed get the data to be serialized
     */
    function getData()
    {
        $data = array(
            'currentRoute' => \Route::getCurrentRoute(),
        );

        $base_path = Request::root();

        $routes = \Route::getRoutes()->all();

        $results = array();
        foreach ($routes as $name => $route) {
            $results[] = $this->getRouteInformation($name, $route, $data['currentRoute'], $base_path);
        }

        $data['routes'] = $results;

        return array('router' => $data);
    }

    /**
     * Get the route information for a given route.
     *
     * @param  string $name
     * @param  Route $route
     * @param  Route $current the current route
     * @param  string $base_path
     * @return array
     */
    protected function getRouteInformation($name, Route $route, Route $current, $base_path)
    {
        $path = $route->getPath();

        $uri = head($route->getMethods()) . ' <a href="' . $base_path . $path . '">' . $path . '</a>';

        $action = $route->getAction() ? : 'Closure';

        return array(
            'current' => ($current == $route),
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
