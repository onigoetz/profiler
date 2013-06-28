<?php namespace Onigoetz\Profiler;

use App;
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
        $config = app('config');

        // Add the namespace manually as the namespace isn't loaded
        // for the moment : `boot` is called after `register`
        $config->addNamespace('profiler', __DIR__ . '/../../config');

        //TODO :: render it at the right place
        //TODO :: generate data before
        if (App::environment() !== 'production' && $config->get('profiler::profiler.enabled', true)) {

            $toolbar = new Toolbar();

            $this->app->finish(
                function (Request $request, Response $response) use ($toolbar) {

                    if (!$request->ajax()) {
                        $toolbar->generateData();
                        echo $toolbar->render()->render();
                    }

                }
            );
        }

        $this->app['stopwatch'] = $this->app->share(
            function () {
                return new Stopwatch;
            }
        );
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
