<?php

namespace AlexvanVliet\ImprovedResponses\Routing;

use AlexvanVliet\ImprovedResponses\Http\JsonResponse;
use AlexvanVliet\ImprovedResponses\Http\Response;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Routing\ResponseFactory as BaseResponseFactory;
use JsonSerializable;

class ResponseFactory extends BaseResponseFactory
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
     * Return a new JSON response from the application.
     *
     * @param  string|array $data
     * @param  int          $status
     * @param  array        $headers
     * @param  int          $options
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function json ($data = [], $status = 200, array $headers = [], $options = 0)
    {
        if ($data instanceof Arrayable && !$data instanceof JsonSerializable)
        {
            $data = $data->toArray();
        }

        return new JsonResponse($data, $status, $headers, $options, $this->bindings);
    }

    /**
     * Return a new response from the application.
     *
     * @param  string $content
     * @param  int    $status
     * @param  array  $headers
     *
     * @return \Illuminate\Http\Response
     */
    public function make ($content = '', $status = 200, array $headers = [])
    {
        return new Response($content, $status, $headers, $this->bindings);
    }
}