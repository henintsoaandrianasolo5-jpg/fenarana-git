<?php
declare(strict_types=1);

class AuthMiddleware implements Middleware
{
    public function handle(Request $request, callable $next): void
    {
        // Demo auth guard: require cart to have items, otherwise redirect to cart.
        $items = $_SESSION['cart'] ?? [];
        if (!is_array($items) || count($items) === 0) {
            Response::redirect('/cart');
            return;
        }


        $next();
    }
}

