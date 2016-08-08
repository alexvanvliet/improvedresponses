<?php

namespace AlexvanVliet\ImprovedResponses\Routing;

use AlexvanVliet\ImprovedResponses\Http\RedirectResponse;
use Illuminate\Routing\Redirector as BaseRedirector;

class Redirector extends BaseRedirector
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
     * Create a new redirect response.
     *
     * @param  string $path
     * @param  int    $status
     * @param  array  $headers
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function createRedirect ($path, $status, $headers)
    {
        $redirect = new RedirectResponse($path, $status, $headers, $this->bindings);

        if (isset($this->session))
        {
            $redirect->setSession($this->session);
        }

        $redirect->setRequest($this->generator->getRequest());

        return $redirect;
    }
}