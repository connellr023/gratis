<h1 align="center">
 <img src="https://github.com/connellr023/gratis/blob/main/public/images/logo_small.png?raw=true" width="150px" />
 <br />
 <div>Middlewares</div>
</h1>

> [Back To Index](INDEX.md)

<br />

### Creating Middleware Handlers
Middleware handlers are classes that implement the `IMiddlewareHandler` interface.
They are the first to be triggered when a request is received and have access and control over the following
properties,
 - Client request object
 - Client response object
 - Next middleware function on the call stack

These properties are accessed through the overridable `handle_middleware` function to allow API
developers to conditionally make decisions regarding how to handle client requests before they
are dispatched to a controller end-point.

<br />

### Registering Middleware Handlers
Middleware handlers are registered to a `Router` object via the `register_middleware` function.

#### Example
> *index.php*
```php
use \Gratis\Framework\Router\IMiddlewareHandler;
use \Gratis\Framework\HTTP\Request;
use \Gratis\Framework\HTTP\Response;
use Override;

require_once __DIR__ . "vendor/autoload.php";

$router = new Router();

$router->register_middleware(new class implements IMiddlewareHandler {

    #[Override]
    public function handle_middleware(Request $req, Response $res, Closure $next): Response
    {
        // Handle middleware logic here
        $res->append_content("Content from middleware");    // Request handlers will receive response
                                                            // object with appended content
                                                            
        $res->set_headers("Content-Type: text/html");       // Change the content type to `text/html`
        
        $next($req, $res)                                   // Call next middleware function
                                                            // Can be conditionally called
                                                          
        return $res;                                        // Must return a response object
    }
});

$router->dispatch();
```
The above example uses an anonymous class to handle middleware logic, however it is better practice
to separate it into a separate file with a concrete class.