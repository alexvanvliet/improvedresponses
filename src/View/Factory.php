<?php

namespace AlexvanVliet\ImprovedResponses\View;

use Illuminate\View\Factory as BaseFactory;

class Factory extends BaseFactory
{
    /**
     * List of the method bindings.
     *
     * @var array
     */
    protected $bindings = [];

    /**
     * Add a method binding.
     *
     * @param          $name
     * @param callable $function
     */
    public function bind ($name, callable $function)
    {
        $this->bindings[ $name ] = $function;
    }

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string $view
     * @param  array  $data
     * @param  array  $mergeData
     *
     * @return \Illuminate\Contracts\View\View
     */
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