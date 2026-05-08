<?php
declare(strict_types=1);

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, array $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    private function add(string $method, string $path, array $handler): void
    {
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(): void
    {
        $request = new Request();
        $method = $request->method;
        $path = $request->path;

        $handler = $this->routes[$method][$path] ?? null;
        if (!$handler) {
            http_response_code(404);
            echo '404 Not Found';
            return;
        }

        [$class, $func] = $handler;
        $controller = new $class();

        // Middleware pipeline (simple)
        $middlewares = [];
        if ($controller instanceof MiddlewareAware) {
            $middlewares = $controller->middlewares();
        }

        $runner = new MiddlewareRunner($middlewares, $controller, $func, $request);
        $runner->run();
    }
}

interface MiddlewareAware
{
    /** @return string[] list of middleware class names */
    public function middlewares(): array;
}

class MiddlewareRunner
{
    /** @var string[] */
    private array $middlewares;
    private object $controller;
    private string $method;
    private Request $request;

    /** @param string[] $middlewares */
    public function __construct(array $middlewares, object $controller, string $method, Request $request)
    {
        $this->middlewares = $middlewares;
        $this->controller = $controller;
        $this->method = $method;
        $this->request = $request;
    }

    public function run(): void
    {
        $next = function () {
            $method = $this->method;
            $this->controller->$method($this->request);
        };

        // Build pipeline backwards
        foreach (array_reverse($this->middlewares) as $mwClass) {
            $prevNext = $next;
            $next = function () use ($mwClass, $prevNext) {
                $mw = new $mwClass();
                if (!$mw instanceof Middleware) {
                    $prevNext();
                    return;
                }
                $mw->handle($this->request, $prevNext);
            };
        }

        $next();
    }
}

