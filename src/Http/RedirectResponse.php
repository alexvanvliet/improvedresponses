<?php

namespace AlexvanVliet\ImprovedResponses\Http;

use Illuminate\Http\RedirectResponse as BaseRedirectResponse;

class RedirectResponse extends BaseRedirectResponse
{
    /**
     * List of the method bindings.
     *
     * @var array
     */
    protected $bindings;

    /**
     * Creates a redirect response so that it conforms to the rules defined for a redirect status code.
     *
     * @param string $url     The URL to redirect to. The URL should be a full URL, with schema etc.,
     *                        but practically every browser redirects on paths only as well
     * @param int    $status  The status code (302 by default)
     * @param array  $headers The headers (Location is always set to the given URL)
     * @param array  $bindings
     *
     * @throws \InvalidArgumentException
     *
     * @see http://tools.ietf.org/html/rfc2616#section-10.3
     */
    public function __construct ($url, $status, array $headers, array $bindings)
    {
        parent::__construct($url, $status, $headers);
        $this->bindings = $bindings;
    }

    /**
     * Dynamically bind flash data in the session or call a bound method.
     *
     * @param  string $name
     * @param  array  $arguments
     *
     * @return $this
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