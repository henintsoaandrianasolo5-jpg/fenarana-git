<?php
declare(strict_types=1);

require_once __DIR__ . '/http/Request.php';
require_once __DIR__ . '/http/Response.php';
require_once __DIR__ . '/router/Router.php';
require_once __DIR__ . '/view/View.php';

require_once __DIR__ . '/middleware/Middleware.php';
require_once __DIR__ . '/middleware/LoggerMiddleware.php';
require_once __DIR__ . '/middleware/AuthMiddleware.php';

require_once __DIR__ . '/db/Connection.php';

require_once __DIR__ . '/repositories/ProductRepository.php';
require_once __DIR__ . '/repositories/CartRepository.php';


require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/CartController.php';
require_once __DIR__ . '/controllers/CheckoutController.php';

// session for cart
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

