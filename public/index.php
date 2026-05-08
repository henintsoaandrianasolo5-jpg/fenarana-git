<?php
declare(strict_types=1);

// Simple front controller
require_once __DIR__ . '/../src/autoload.php';
require_once __DIR__ . '/../src/bootstrap.php';

$router = new Router();

// Routes
$router->get('/', [ProductController::class, 'home']);
$router->get('/products', [ProductController::class, 'index']);
$router->get('/product', [ProductController::class, 'show']); // ?id=1

$router->post('/cart/add', [CartController::class, 'add']); // product_id
$router->get('/cart', [CartController::class, 'view']);
$router->post('/cart/remove', [CartController::class, 'remove']); // product_id

$router->get('/checkout', [CheckoutController::class, 'index']);
$router->post('/checkout', [CheckoutController::class, 'process']);

$router->dispatch();

