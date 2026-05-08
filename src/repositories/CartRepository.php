<?php
declare(strict_types=1);

class CartRepository
{
    /** @return array<int,int> productId => qty */
    public function get(): array
    {
        return $_SESSION['cart'] ?? [];
    }

    public function add(int $productId, int $qty = 1): void
    {
        $cart = $this->get();
        $cart[$productId] = ($cart[$productId] ?? 0) + $qty;
        $_SESSION['cart'] = $cart;
    }

    public function remove(int $productId): void
    {
        $cart = $this->get();
        unset($cart[$productId]);
        $_SESSION['cart'] = $cart;
    }

    public function clear(): void
    {
        $_SESSION['cart'] = [];
    }

    public function count(): int
    {
        $cart = $this->get();
        return array_sum($cart);
    }

    /**
     * @return array<int, array{id:int,name:string,unit_price:float,qty:int,subtotal:float,image:string}>
     */
    public function itemsDetailed(ProductRepository $products): array
    {
        $cart = $this->get();
        $items = [];
        foreach ($cart as $productId => $qty) {
            $p = $products->find((int)$productId);
            if (!$p) continue;

            $unitPrice = (float)$p['price'];
            $items[] = [
                'id' => (int)$p['id'],
                'name' => $p['name'],
                'unit_price' => $unitPrice,
                'qty' => (int)$qty,
                'subtotal' => $unitPrice * (int)$qty,
                'image' => $p['image'],
            ];
        }
        return $items;
    }

    public function total(ProductRepository $products): float
    {
        $sum = 0.0;
        foreach ($this->itemsDetailed($products) as $it) {
            $sum += (float)$it['subtotal'];
        }
        return $sum;
    }
}

