<?php namespace Onigoetz\Profiler\Support\Laravel;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Onigoetz\Profiler\DataCollector\FilesDataCollector;
use Onigoetz\Profiler\DataContainer;
use Onigoetz\Profiler\Output\Toolbar;
use Onigoetz\Profiler\Support\Laravel\DataCollector\DatabaseDataCollector;
use Onigoetz\Profiler\Support\Laravel\DataCollector\MonologDataCollector;
use Onigoetz\Profiler\Support\Laravel\DataCollector\Router41DataCollector;
use Onigoetz\Profiler\Support\Laravel\DataCollector\RouterDataCollector;
use Onigoetz\Profiler\Support\Laravel\DataCollector\TimeDataCollector;
use Onigoetz\Profiler\Support\Laravel\DataCollector\VariablesDataCollector;
use Onigoetz\Profiler\Tools\Config;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Stopwatch\Stopwatch;

class ProfilerServiceProvider extends ServiceProvider
{

    protected $packageName = 'onigoetz/profiler';

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package($this->packageName);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $in_app_file = $this->app['path'] . '/config/packages/' . $this->packageName . '/profiler.php';
        Config::init(file_exists($in_app_file) ? $in_app_file : null);

        // Stopwatch - must be registered so the application doesn't fail if the profiler is disabled
        $this->app['stopwatch'] = $this->app->share(
            function () {
                $stopwatch = new Stopwatch;
                $stopwatch->openSection(); //open application wide section
                return $stopwatch;
            }
        );

        if (
            !in_array($this->app->environment(), Config::get('environments_blacklist'))
            && Config::get('enabled', true)
        ) {
            $this->needsRegister();
        }
    }

    public function needsRegister()
    {
        $this->app['stopwatch']->start('Application initialisation.', 'section');

        // Collect
        $collectors = new DataContainer;
        $collectors
            ->add(new MonologDataCollector)
            ->add(new FilesDataCollector)
            ->add(new DatabaseDataCollector)
            ->add(new TimeDataCollector)
            ->add(new VariablesDataCollector);
            //->setStorage(new FileStorage(array('path' => $this->app['path.storage'] . '/profiler')));

        // Laravel 4.1 has a new routing layer, some stuff is different
        if (class_exists('\Illuminate\Routing\Controllers\Controller')) {
            $collectors->add(new RouterDataCollector);
        } else {
            $collectors->add(new Router41DataCollector);
        }

        $this->app->before(array($collectors, 'register'));

        // Populate timeline
        $this->app->booting(array($this, 'booting'));
        $this->app->booted(array($this, 'booted'));
        $this->app->before(array($this, 'start_router_dispatch'));
        $this->app->after(array($this, 'stop_router_dispatch'));

        $this->app->close(
            function (Request $request, Response $response) use ($collectors) {

                app('stopwatch')->stop('Framework running.');

                if (app()->runningInConsole()) {
                    //TODO :: console only output
                } elseif (!$request->ajax() && strpos($response->headers->get('Content-Type'), 'text/html') === 0) {
                    $collectors->generateData();
                    $collectors->saveData();

                    // Generate display
                    $toolbar = new Toolbar($collectors);
                    $response->setContent($response->getContent() . $toolbar->render());
                }
            }
        );
    }

    public function booting()
    {
        $this->app['stopwatch']->stop('Application initialisation.');
        $this->app['stopwatch']->start('Framework booting.', 'section');
        $this->app['stopwatch']->start('Framework running.', 'section');
    }

    public function booted()
    {
        $this->app['stopwatch']->stop('Framework booting.');
    }

    public function start_router_dispatch()
    {
        $this->app['stopwatch']->start('Router dispatch.', 'section');
    }

    public function stop_router_dispatch()
    {
        $this->app['stopwatch']->stop('Router dispatch.');
    }
}
