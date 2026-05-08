<?php
declare(strict_types=1);

class ProductController
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

    // GET /
    public function home(Request $request): void
    {
        $this->index($request);
    }

    // GET /products
    public function index(Request $request): void
    {
        $products = $this->products->all();

        $this->view->render('products/index', [
            'products' => $products,
            'cartCount' => $this->cart->count(),
            'activeRoute' => '/products',
        ]);
    }

    // GET /product?id=...
    public function show(Request $request): void
    {
        $id = (int)($request->query['id'] ?? 0);
        $product = $this->products->find($id);

        if (!$product) {
            http_response_code(404);
            echo 'Produit introuvable';
            return;
        }

        $this->view->render('products/show', [
            'product' => $product,
            'cartCount' => $this->cart->count(),
            'activeRoute' => '/product',
        ]);
    }
}

