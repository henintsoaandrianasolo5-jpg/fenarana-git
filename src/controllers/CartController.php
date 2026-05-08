<?php
declare(strict_types=1);

class CartController
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

    // POST /cart/add
    public function add(Request $request): void
    {
        $productId = (int)($request->post['product_id'] ?? 0);
        $qty = (int)($request->post['qty'] ?? 1);
        if ($productId <= 0) {
            http_response_code(400);
            echo 'product_id manquant';
            return;
        }

        $this->cart->add($productId, max(1, $qty));
        header('Location: /cart');
        exit;
    }

    // GET /cart
    public function view(Request $request): void
    {
        $items = $this->cart->itemsDetailed($this->products);

        $this->view->render('cart/view', [
            'items' => $items,
            'cartTotal' => $this->cart->total($this->products),
            'cartCount' => $this->cart->count(),
            'activeRoute' => '/cart',
        ]);
    }

    // POST /cart/remove
    public function remove(Request $request): void
    {
        $productId = (int)($request->post['product_id'] ?? 0);
        if ($productId <= 0) {
            http_response_code(400);
            echo 'product_id manquant';
            return;
        }

        $this->cart->remove($productId);
        header('Location: /cart');
        exit;
    }
}

