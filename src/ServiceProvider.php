<?php

namespace AlexvanVliet\ImprovedResponses;

use AlexvanVliet\ImprovedResponses\Routing\Redirector;
use AlexvanVliet\ImprovedResponses\Routing\ResponseFactory;
use AlexvanVliet\ImprovedResponses\View\Factory;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param \AlexvanVliet\ImprovedResponses\Routing\ResponseFactory $responseFactory
     */
    public function boot (ResponseFactory $responseFactory)
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register ()
    {
        $this->registerRedirector();

        $this->registerViewFactory();

        $this->registerResponseFactory();
    }

    /**
     * Register the new redirector.
     */
    private function registerRedirector ()
    {
        $this->app[ 'redirect' ] = $this->app->share(function ($app)
        {
            $redirector = new Redirector($app[ 'url' ]);

            if (isset($app[ 'session.store' ]))
            {
                $redirector->setSession($app[ 'session.store' ]);
            }

            return $redirector;
        });
    }

    /**
     * Register the new view factory.
     */
    private function registerViewFactory ()
    {
        $this->app->singleton('view', function ($app)
        {
            // Next we need to grab the engine resolver instance that will be used by the
            // environment. The resolver will be used by an environment to get each of
            // the various engine implementations such as plain PHP or Blade engine.
            $resolver = $app[ 'view.engine.resolver' ];

            $finder = $app[ 'view.finder' ];

            $env = new Factory($resolver, $finder, $app[ 'events' ]);

            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $env->setContainer($app);

            $env->share('app', $app);

            return $env;
        });
    }

    /**
     * Register the new response factory.
     */
    private function registerResponseFactory ()
    {
        $this->app->singleton('Illuminate\Contracts\Routing\ResponseFactory', function ($app)
        {
            return new ResponseFactory($app[ 'Illuminate\Contracts\View\Factory' ], $app[ 'redirect' ]);
        });
    }
}
