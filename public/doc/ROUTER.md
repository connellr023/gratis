<h1 align="center">
 <img src="https://github.com/connellr023/gratis/blob/main/public/images/logo_small.png?raw=true" width="150px" />
 <br />
 <div>Router Class</div>
</h1>

> [Back To Index](INDEX.md)

<br />

### Overview
```php
class AbstractRouter implements IRouter
```
```php
class Router extends AbstractRouter
```
The `Router` class is a tool used to register middleware as well as request
handlers to specified HTTP methods and routes.

<br />

### Constructor

The **Router** class does not have its own constructor method. It inherits the constructor from the `AbstractRouter` class, which initializes the arrays for middleware handlers and request handlers.

<br />

### Methods

```php
register_middleware(IMiddlewareHandler ...$handlers): void
```

Registers one or more middleware handlers to be triggered on each request.

- **Parameters:**
    - `$handlers` (`IMiddlewareHandler[]`): An array of middleware handlers.

- **Returns:**
    - `void`

<br />

```php
register_route(string $method, string $route, IRequestHandler $handler): void
```

Registers a route and associates it with a request handler for a specific HTTP method.

- Parameters:
  - `$method` (`string`): The HTTP method.
  - `$route` (`string`): The route to be registered. Regular expressions are also supported
  in the following format: `< (exp) >` where the RegExp is enclosed in
  angle brackets with a space of padding around it. `(exp)` should also include
  delimiters.
  - `$handler` (`IRequestHandler`): The request handler to be associated with the route.
- Returns:
  - `void`

<br />

**HTTP Method Shortcut Methods**

The `Router` class provides shortcut methods for registering routes with specific HTTP methods:
```php
get(string $route, IRequestHandler $handler): void
```
```php
post(string $route, IRequestHandler $handler): void
```
```php
patch(string $route, IRequestHandler $handler): void
```
```php
put(string $route, IRequestHandler $handler): void
```
```php
delete(string $route, IRequestHandler $handler): void
```    

These methods internally call register_route with the corresponding HTTP method.

Parameters:
- `$route` (`string`): The route to be registered. Regular expressions are also supported.
- `$handler` (`IRequestHandler`): The request handler to be associated with the route.

Returns:
- `void`

<br />

```php
serve_app(string $app_build_path, string $default_file_path): void
```
Designed to serve a single-page web application (SPA) at the root route ("/"). It is particularly useful for SPAs where the frontend framework handles client-side routing, and the server statically serves all files from a specified directory. This method associates a route pattern with a controller that serves the static files located in the given `$app_build_path` directory. Additionally, a default file can be specified to serve if no other file is found.

Parameters

- `$app_build_path` (`string`): The full path to the directory containing the app's static markup.
- `$default_file_path` (`string`): The full path to the default file to be served if no other file is found.

Returns:
- `void`

<br />

```php
dispatch(): void
```

Starts listening for requests and dispatches them to the appropriate middleware and request handler(s). Request handlers are triggered only if the middleware handlers produce a successful HTTP status code.

Returns:
- `void`

<br />

### Example Usage
```php
// Instantiate a new router instance
$router = new Router();
$request_handler = new EchoController("Hello World"); // Example request handler

// Registers the request handler to a `POST` request
// The RegExp used matches all routes via `POST`
$router->post("< ~(.*)~ >", $request_handler);

// Serve an SPA located in `View` directory
$router->serve_app(__DIR__ . "/View", __DIR__ . "/View/index.html");

// Listen for incoming HTTP requests
$router->dispatch();
```