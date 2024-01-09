<h1 align="center">
 <img src="https://github.com/connellr023/gratis/blob/main/public/images/logo_small.png?raw=true" width="150px" />
 <br />
 <div>Controllers</div>
</h1>

> [Back To Index](INDEX.md)

<br />

### Creating Controllers
Controllers are classes that implement the `IRequestHandler` interface.
They are triggered when a request is received and have access and control over the following
properties,
- Client request object
- Client response object

It is important to note that *exactly one* controller will be triggered per HTTP request. Similar to middlewares,
The above properties can be accessed via the `handle_request` function.

### Registering Controllers
Controllers are registered to a `Router` object via the following functions,
- `register_route`
- `get`
- `post`
- `patch`
- `put`
- `delete`

Where the `register_route` function is used to register any request method and
the functions following it are simply aliases.


#### Example
> *index.php*
```php
$router = new Router();
$hello_world_controller = new EchoController("Hello World");

$router->get("/", $hello_world_controller);

$router->dispatch();
```

<br />

> *EchoController.php*
```php
class EchoController implements IRequestHandler
{
    private string $echo;

    public function __construct(string $echo)
    {
        $this->echo = $echo;
    }

    #[Override]
    public function handle_request(Request $req, Response $res): void
    {
        echo $this->echo;
    }
}
```
The above example will result in a "Hello World" message to be sent when a client
accesses the "/" route via a **GET** HTTP request.