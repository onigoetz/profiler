<?php namespace Onigoetz\Profiler\Support\Laravel;

use App;
use Log;
use Onigoetz\Profiler\DataContainer;
use Onigoetz\Profiler\DataCollector\FilesDataCollector;
use Onigoetz\Profiler\Support\Laravel\DataCollector\MonologDataCollector;
use Onigoetz\Profiler\Support\Laravel\DataCollector\DatabaseDataCollector;
use Onigoetz\Profiler\Support\Laravel\DataCollector\RouterDataCollector;
use Onigoetz\Profiler\Support\Laravel\DataCollector\VariablesDataCollector;
use Onigoetz\Profiler\Support\Laravel\DataCollector\TimeDataCollector;
use Onigoetz\Profiler\Output\Toolbar;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Stopwatch\Stopwatch;

class ProfilerServiceProvider extends ServiceProvider
{
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

        if (App::environment() !== 'production' && $config->get('profiler::profiler.enabled', true)) {
            $this->needsRegister();
        }
    }

    public function needsRegister()
    {
        // Stopwatch
        $this->app['stopwatch'] = $this->app->share(
            function () {
                $stopwatch = new Stopwatch;
                $stopwatch->openSection(); //open application wide section
                return $stopwatch;
            }
        );

        $this->app['stopwatch']->start('Application initialisation.', 'section');

        // Collect
        $collectors = new DataContainer;
        $collectors
            ->add(new MonologDataCollector)
            ->add(new FilesDataCollector)
            ->add(new DatabaseDataCollector)
            ->add(new RouterDataCollector)
            ->add(new TimeDataCollector)
            ->add(new VariablesDataCollector);

        $this->app->before(array($collectors, 'register'));

        // Prepare Display
        $toolbar = new Toolbar($collectors);

        // Populate timeline
        $this->app->booting(array($this, 'booting'));
        $this->app->booted(array($this, 'booted'));
        $this->app->before(array($this, 'start_router_dispatch'));
        $this->app->after(array($this, 'stop_router_dispatch'));

        $this->app->finish(
            function (Request $request, Response $response) use ($toolbar, $collectors) {

                app('stopwatch')->stop('Framework running.');

                if (!$request->ajax()) {
                    $collectors->generateData();
                    echo $toolbar->render();
                }
            }
        );
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
}
