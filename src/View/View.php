<?php

namespace AlexvanVliet\ImprovedResponses\View;

use Illuminate\View\Engines\EngineInterface;
use Illuminate\View\View as BaseView;

class View extends BaseView
{
    /**
     * List of the method bindings.
     *
     * @var array
     */
    protected $bindings;

    /**
     * Create a new view instance.
     *
     * @param \AlexvanVliet\ImprovedResponses\View\Factory $factory
     * @param  \Illuminate\View\Engines\EngineInterface    $engine
     * @param  string                                      $view
     * @param  string                                      $path
     * @param  mixed                                       $data
     * @param  array                                       $bindings
     */
    public function __construct (Factory $factory, EngineInterface $engine, $view, $path, $data, array $bindings)
    {
        parent::__construct($factory, $engine, $view, $path, $data);
        $this->bindings = $bindings;
    }

    /**
     * Dynamically bind parameters to the view or call a bound method.
     *
     * @param  string $name
     * @param  array  $arguments
     *
     * @return \Illuminate\View\View
     *
     * @throws \BadMethodCallException
     */
    public function __call ($name, $arguments)
    {
        if (!isset($this->bindings[ $name ]))
        {
            parent::__call($name, $arguments);

            return $this;
        }

        app()->call($this->bindings[ $name ], $arguments);

        return $this;
    }
}