<?php
declare(strict_types=1);

class LoggerMiddleware implements Middleware
{
    public function handle(Request $request, callable $next): void
    {
        $line = sprintf("[%s] %s %s\n", date('c'), $request->method, $request->path);
        file_put_contents(__DIR__ . '/../../runtime.log', $line, FILE_APPEND);
        $next();
    }
}

