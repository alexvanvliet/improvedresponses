<?php

namespace AlexvanVliet\ImprovedResponses\Http;

use Illuminate\Http\Response as BaseResponse;

class Response extends BaseResponse
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
     * @param mixed $content The response content, see setContent()
     * @param int   $status  The response status code
     * @param array $headers An array of response headers
     * @param array $bindings
     *
     * @throws \InvalidArgumentException When the HTTP status code is not valid
     */
    public function __construct ($content, $status, array $headers, array $bindings)
    {
        parent::__construct($content, $status, $headers);
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