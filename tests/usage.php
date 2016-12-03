#!/usr/bin/env php
<?php

namespace Cormy;

require __DIR__.'/../vendor/autoload.php';

use {{namespace}}\{{class_name}};
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

// create a response factory
$responseFactory = function (ServerRequestInterface $request):ResponseInterface {
    return new \Zend\Diactoros\Response();
};

// {{create_description}}
$requestHandler = new {{class_name}}($responseFactory);

// handle a request
$response = $requestHandler(new \Zend\Diactoros\ServerRequest());

exit($response->getHeader('X-PoweredBy')[0] === '{{class_name}}s' ? 0 : 1);
