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
        $config = app('config');

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

            $this->app->booting(
                function () use ($stopwatch) {
                    $stopwatch->stop('Application initialisation.');
                    $stopwatch->start('Framework booting.', 'section');
                    $stopwatch->start('Framework running.', 'section');
                }
            );

            $this->app->booted(
                function () use ($stopwatch) {
                    $stopwatch->stop('Framework booting.');
                }
            );

            $this->app->finish(
                function (Request $request, Response $response) use ($toolbar, $stopwatch) {

                    $stopwatch->stop('Framework running.');

                    if (!$request->ajax()) {
                        $toolbar->generateData();
                        echo $toolbar->render()->render();
                    }
                }
            );


            $this->app->before(
                function () use ($stopwatch) {
                    $stopwatch->start('Router dispatch.', 'section');
                }
            );

            $this->app->after(
                function () use ($stopwatch) {
                    $stopwatch->stop('Router dispatch.');
                }
            );
        }


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
