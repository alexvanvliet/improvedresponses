<?php

namespace AlexvanVliet\ImprovedResponses\View;

use Illuminate\View\Factory as BaseFactory;

class Factory extends BaseFactory
{
    /**
     * @var array
     */
    protected $bindings = [];

    public function bind ($name, callable $function)
    {
        $this->bindings[ $name ] = $function;
    }


    public function make ($view, $data = [], $mergeData = [])
    {
        if (isset($this->aliases[ $view ]))
        {
            $view = $this->aliases[ $view ];
        }

        $view = $this->normalizeName($view);

        $path = $this->finder->find($view);

        $data = array_merge($mergeData, $this->parseData($data));

        $this->callCreator($view = new View($this, $this->getEngineFromPath($path), $view, $path, $data, $this->bindings));

        return $view;
    }
}