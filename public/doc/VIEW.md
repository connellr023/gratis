<h1 align="center">
 <img src="https://github.com/connellr023/gratis/blob/main/public/images/logo_small.png?raw=true" width="150px" />
 <br />
 <div>View</div>
</h1>

> [Back To Index](INDEX.md)

<br />

### Overview
In this framework, the *view* is simply a directory containing static files to be served to the
root route, "/". The view is ideally a single-page web application created with a frontend framework
such as **Vue.js**. Of course, the *view* is completely optional if your API does not require web page serving.

<br />

### Serving a Single-Page Web App
Static files can be served by using the `serve_app` function from a `Router` instance.

#### Example
> *index.php*
```php
use Gratis\Framework\Router\Router;
use Override;

require_once __DIR__ . "../vendor/autoload.php";

$router = new Router();

$router->serve_app(__DIR__ . "/View", __DIR__ . "/View/index.html");

$router->dispatch();
```
The above example serves a single-page web application built within the `View` directory. Additionally,
`index.html` indicates the file that should be sent by default when a client accesses the route, "/" for instance.