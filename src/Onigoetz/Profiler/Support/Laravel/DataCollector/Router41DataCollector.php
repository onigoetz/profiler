<?php namespace Onigoetz\Profiler\Support\Laravel\DataCollector;

use Request;
use Onigoetz\Profiler\DataCollector\DataCollector;
use Illuminate\Routing\Route;

class Router41DataCollector extends DataCollector
{
    /**
     * @var \Illuminate\Routing\Router
     */
    private $router;

    /**
     * @var \Illuminate\Routing\UrlGenerator
     */
    private $url;


    public function provides()
    {
        return array('router');
    }

    /**
     * @return mixed get the data to be serialized
     */
    public function getData()
    {
        $this->router = app('router');
        $this->url = app('url');

        $data = array(
            'currentRoute' => $this->router->current(),
        );

        $routes = $this->router->getRoutes();

        $results = array();
        foreach ($routes as $name => $route) {
            $results[] = $this->getRouteInformation($route, $data['currentRoute']);
        }

        $data['routes'] = $results;

        return array('router' => $data);
    }

    protected function getRouteInformation(Route $route, $current)
    {
        $uri = implode(' | ', $route->methods()).' <a href="' . $this->url->to($route->uri()) . '">' . $route->uri() . '</a>';

        return array(
            'current' => ($current == $route),
            'host'   => $route->domain(),
            'uri'    => $uri,
            'name'   => $route->getName(),
            'action' => $route->getActionName(),
            'before' => $this->getBeforeFilters($route),
            'after'  => $this->getAfterFilters($route)
        );
    }

    /**
     * Get before filters
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return string
     */
    protected function getBeforeFilters($route)
    {
        $before = array_keys($route->beforeFilters());

        $before = array_unique(array_merge($before, $this->getPatternFilters($route)));

        return implode(', ', $before);
    }

    /**
     * Get all of the pattern filters matching the route.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return array
     */
    protected function getPatternFilters($route)
    {
        $patterns = array();

        foreach ($route->methods() as $method)
        {
            // For each method supported by the route we will need to gather up the patterned
            // filters for that method. We will then merge these in with the other filters
            // we have already gathered up then return them back out to these consumers.
            $inner = $this->getMethodPatterns($route->uri(), $method);

            $patterns = array_merge($patterns, array_keys($inner));
        }

        return $patterns;
    }

    /**
     * Get the pattern filters for a given URI and method.
     *
     * @param  string  $uri
     * @param  string  $method
     * @return array
     */
    protected function getMethodPatterns($uri, $method)
    {
        return $this->router->findPatternFilters(Request::create($uri, $method));
    }

    /**
     * Get after filters
     *
     * @param  Route  $route
     * @return string
     */
    protected function getAfterFilters($route)
    {
        return implode(', ', array_keys($route->afterFilters()));
    }
}
