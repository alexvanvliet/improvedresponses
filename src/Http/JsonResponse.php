<?php

namespace AlexvanVliet\ImprovedResponses\Http;

use Illuminate\Http\JsonResponse as BaseJsonResponse;

class JsonResponse extends BaseJsonResponse
{
    /**
     * @var array
     */
    protected $bindings;

    public function __construct ($data, $status, array $headers, $options, array $bindings)
    {
        parent::__construct($data, $status, $headers, $options);
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