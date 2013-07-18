<?php namespace Onigoetz\Profiler;

use App;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Stopwatch\Stopwatch;

class ProfilerServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('onigoetz/profiler');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $config = $this->app['config'];

        // Add the namespace manually as the namespace isn't loaded
        // for the moment : `boot` is called after `register`
        $config->addNamespace('profiler', __DIR__ . '/../../config');


        $this->app['stopwatch'] = $this->app->share(
            function () {
                $stopwatch = new Stopwatch;
                $stopwatch->openSection(); //open application wide section
                return $stopwatch;
            }
        );

        $stopwatch = $this->app['stopwatch'];

        //TODO :: render it at the right place
        //TODO :: generate data before
        if (App::environment() !== 'production' && $config->get('profiler::profiler.enabled', true)) {

            $toolbar = new Toolbar();

            $stopwatch->start('Application initialisation.', 'section');

            //Populate timeline
            $this->app->booting(array($this, 'booting'));
            $this->app->booted(array($this, 'booted'));
            $this->app->before(array($this, 'start_router_dispatch'));
            $this->app->after(array($this, 'stop_router_dispatch'));

            $this->app->finish(
                function (Request $request, Response $response) use ($toolbar, $stopwatch) {

                    $stopwatch->stop('Framework running.');

                    if (!$request->ajax()) {
                        $toolbar->generateData();
                        echo $toolbar->render()->render();
                    }
                }
            );
        }
    }

    public function booting() {
        $this->app['stopwatch']->stop('Application initialisation.');
        $this->app['stopwatch']->start('Framework booting.', 'section');
        $this->app['stopwatch']->start('Framework running.', 'section');
    }

    public function booted()
    {
        $this->app['stopwatch']->stop('Framework booting.');
    }

    public function start_router_dispatch() {
        $this->app['stopwatch']->start('Router dispatch.', 'section');
    }

    public function stop_router_dispatch() {
        $this->app['stopwatch']->stop('Router dispatch.');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
