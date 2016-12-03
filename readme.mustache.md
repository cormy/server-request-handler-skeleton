# Cormy\Server\RequestHandler\{{class_name}} {{travis}} {{coveralls}} {{scrutinizer}}

{{sensio_labs_insight}}

> {{description}}.


## Install

```
composer require {{package}}
```


## Usage

```php
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
```


## API

### `Cormy\Server\RequestHandler\{{class_name}} implements Cormy\Server\RequestHandlerInterface`

#### `{{class_name}}::__construct`

```php
/**
 * {{create_description}}.
 *
 * @param callable $responseFactory factory method used to create ResponseInterface instances
 */
public function __construct(callable $responseFactory)
```

#### Inherited from [`Cormy\Server\RequestHandlerInterface::__invoke`](https://github.com/cormy/server-request-handler)

```php
/**
 * Process an incoming server request and return the response.
 *
 * @param ServerRequestInterface $request
 *
 * @return ResponseInterface
 */
public function __invoke(ServerRequestInterface $request):ResponseInterface
```


## Related

* [Cormy\Server\Onion](https://github.com/cormy/onion) – Onion style PSR-7 **middleware stack** using generators
* [Cormy\Server\Bamboo](https://github.com/cormy/bamboo) – Bamboo style PSR-7 **middleware pipe** using generators
* [Cormy\Server\RequestHandlerInterface](https://github.com/cormy/server-request-handler) – Common interfaces for PSR-7 server request handlers
* [Cormy\Server\MiddlewareInterface](https://github.com/cormy/server-middleware) – Common interfaces for Cormy PSR-7 server middlewares
* [PSR-7: HTTP message interfaces](http://www.php-fig.org/psr/psr-7/)


## License

MIT © {{user_link}}
