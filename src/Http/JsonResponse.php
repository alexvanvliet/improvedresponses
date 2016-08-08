<?php

namespace AlexvanVliet\ImprovedResponses\Http;

use Illuminate\Http\JsonResponse as BaseJsonResponse;

class JsonResponse extends BaseJsonResponse
{
    /**
     * List of the method bindings.
     *
     * @var array
     */
    protected $bindings;

    /**
     * Constructor.
     *
     * @param  mixed $data
     * @param  int   $status
     * @param  array $headers
     * @param  int   $options
     * @param array  $bindings
     */
    public function __construct ($data, $status, array $headers, $options, array $bindings)
    {
        parent::__construct($data, $status, $headers, $options);
        $this->bindings = $bindings;
    }

    /**
     * Call a bound method.
     *
     * @param $name
     * @param $arguments
     *
     * @return $this
     */
    public function __call ($name, $arguments)
    {
        if (!isset($this->bindings[ $name ]))
        {
            return $this;
        }

        app()->call($this->bindings[ $name ], $arguments);

        return $this;
    }
}