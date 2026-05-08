<?php
declare(strict_types=1);

class CheckoutController implements MiddlewareAware
{
    private ProductRepository $products;
    private CartRepository $cart;
    private View $view;

    public function __construct()
    {
        $this->products = new ProductRepository();
        $this->cart = new CartRepository();
        $this->view = new View();
    }

    public function middlewares(): array
    {
        // Example: protect checkout with AuthMiddleware (demo)
        return ['LoggerMiddleware', 'AuthMiddleware'];
    }

    // GET /checkout
    public function index(Request $request): void
    {
        $items = $this->cart->itemsDetailed($this->products);
        $total = $this->cart->total($this->products);

        if (count($items) === 0) {
            header('Location: /cart');
            exit;
        }

        $this->view->render('checkout/index', [
            'items' => $items,
            'cartTotal' => $total,
            'cartCount' => $this->cart->count(),
            'activeRoute' => '/checkout',
        ]);
    }

    // POST /checkout
    public function process(Request $request): void
    {
        $customerName = trim((string)($request->post['customer_name'] ?? ''));
        $customerEmail = trim((string)($request->post['customer_email'] ?? ''));

        if ($customerName === '' || $customerEmail === '') {
            http_response_code(400);
            echo 'Nom et email requis';
            return;
        }

        // For demo: create order in DB
        $orderId = $this->products->createOrderFromCart($customerName, $customerEmail, $this->cart);
        $this->cart->clear();

        $this->view->render('checkout/success', [
            'orderId' => $orderId,
            'cartCount' => 0,
            'activeRoute' => '/checkout',
        ]);
    }
}

