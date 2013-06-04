<?php namespace Onigoetz\Profiler;

use App;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

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
        $toolbar = new Toolbar();

        //TODO :: render it at the right place
        //TODO :: generate data before

        if (App::environment() !== 'production' and app('config')->get('profiler::enabled', true)) {
            $this->app->finish(
                function (Request $request, Response $response) use ($toolbar) {

                    if (!$request->ajax()) {
                        echo $toolbar->render()->render();
                    }

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
