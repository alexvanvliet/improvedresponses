<?php

namespace AlexvanVliet\ImprovedResponses\Http;

use Illuminate\Http\RedirectResponse as BaseRedirectResponse;

class RedirectResponse extends BaseRedirectResponse
{
    /**
     * @var array
     */
    protected $bindings;

    public function __construct ($url, $status, array $headers, array $bindings)
    {
        parent::__construct($url, $status, $headers);
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