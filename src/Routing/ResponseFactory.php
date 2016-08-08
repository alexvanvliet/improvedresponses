<?php

namespace AlexvanVliet\ImprovedResponses\Routing;

use AlexvanVliet\ImprovedResponses\Http\JsonResponse;
use AlexvanVliet\ImprovedResponses\Http\Response;
use Illuminate\Routing\ResponseFactory as BaseResponseFactory;

class ResponseFactory extends BaseResponseFactory
{
    /**
     * @var array
     */
    protected $bindings = [];

    public function bind ($name, callable $function)
    {
        $this->bindings[ $name ] = $function;
    }

    public function make ($content = '', $status = 200, array $headers = [])
    {
        return new Response($content, $status, $headers, $this->bindings);
    }

    public function json ($data = [], $status = 200, array $headers = [], $options = 0)
    {
        if ($data instanceof Arrayable && !$data instanceof JsonSerializable)
        {
            $data = $data->toArray();
        }

        return new JsonResponse($data, $status, $headers, $options);
    }
}