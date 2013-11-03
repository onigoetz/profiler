<?php namespace Onigoetz\Profiler\Support\Laravel;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Onigoetz\Profiler\Stopwatch\Stopwatch;
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
use Onigoetz\Profiler\Utils;
use Symfony\Component\HttpFoundation\Response;

class ProfilerServiceProvider extends ServiceProvider
{

    protected $packageName = 'onigoetz/profiler';

    /**
     * @var \Onigoetz\Profiler\DataContainer
     */
    protected $collectors;

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
                return new Stopwatch(LARAVEL_START * 1000);
            }
        );

        // Time collection is done anyway
        $this->collectors = new DataContainer;
        $this->collectors->add(new TimeDataCollector);

        // this will be executed anyway
        $this->app->after(array($this, 'onCloseHeaders'));

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

        // Laravel 4.1 has a new routing layer, some stuff is different
        $is_4_0 =  class_exists('\Illuminate\Routing\Controllers\Controller');

        // Collect
        $this->collectors
            ->add(new MonologDataCollector)
            ->add(new FilesDataCollector)
            ->add(new DatabaseDataCollector)
            ->add(new VariablesDataCollector)
            ->add(($is_4_0) ? new RouterDataCollector : new Router41DataCollector)
            //->setStorage(new FileStorage(array('path' => $this->app['path.storage'] . '/profiler')))
        ;

        $this->app->before(array($this->collectors, 'register'));

        // Populate timeline
        $this->app->booting(array($this, 'onBooting'));
        $this->app->booted(array($this, 'onBooted'));
        $this->app->before(array($this, 'onBefore'));
        $this->app->after(array($this, 'onAfter'));
    }

    public function onCloseHeaders(Request $request, Response $response)
    {
        try {
            $this->app['stopwatch']->stop('Framework running.');
        } catch(\LogicException $e) {
            //no problem here, this event might not be started
        }

        //Generate data anyway
        $this->collectors->generateData();
        $this->collectors->saveData();

        $time = '';
        $time_collector = $this->collectors->getData();
        if (array_key_exists('time', $time_collector)) {
            $time = Utils::getReadableTime($time_collector['time']['totalTime'] * 1000);
        }

        $response->headers->add(
            array(
                'X-Profile-env' => $this->app->environment(),
                'X-Profile-time' => $time
            )
        );
    }

    public function onBooting()
    {
        $this->app['stopwatch']->stop('Application initialisation.');
        $this->app['stopwatch']->start('Framework booting.', 'section');
        $this->app['stopwatch']->start('Framework running.', 'section');
    }

    public function onBooted()
    {
        $this->app['stopwatch']->stop('Framework booting.');
    }

    public function onBefore()
    {
        $this->app['stopwatch']->start('Router dispatch.', 'section');
    }

    public function onAfter(Request $request, Response $response)
    {
        if ($this->app->runningInConsole()) {
            //TODO :: console only output
        } elseif (!$request->ajax() && strpos($response->headers->get('Content-Type'), 'text/html') === 0) {
            // Generate display
            $toolbar = new Toolbar($this->collectors);
            $response->setContent($response->getContent() . $toolbar->render());
        }
    }
}
