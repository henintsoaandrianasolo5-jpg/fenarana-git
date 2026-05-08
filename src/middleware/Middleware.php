<?php
declare(strict_types=1);

interface Middleware
{
    /**
     * @param callable():void $next
     */
    public function handle(Request $request, callable $next): void;
}

