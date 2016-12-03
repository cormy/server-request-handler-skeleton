<?php

namespace {{namespace}};

use Cormy\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Cormy {{class_name}}.
 */
class {{class_name}} implements RequestHandlerInterface
{
    /**
     * @var callable
     */
    protected $responseFactory;

    /**
     * {{create_description}}.
     *
     * @param callable $responseFactory factory method used to create ResponseInterface instances
     */
    public function __construct(callable $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(ServerRequestInterface $request):ResponseInterface
    {
        /* @var $response ResponseInterface */
        $response = ($this->responseFactory)($request);

        return $response->withHeader('X-PoweredBy', '{{class_name}}s');
    }
}
