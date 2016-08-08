<?php

namespace AlexvanVliet\ImprovedResponses\View;

use Illuminate\View\Engines\EngineInterface;
use Illuminate\View\View as BaseView;

class View extends BaseView
{
    /**
     * @var
     */
    protected $bindings;

    public function __construct (Factory $factory, EngineInterface $engine, $view, $path, $data, $bindings)
    {
        parent::__construct($factory, $engine, $view, $path, $data);
        $this->bindings = $bindings;
    }

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