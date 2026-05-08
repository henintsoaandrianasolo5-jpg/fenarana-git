<?php
declare(strict_types=1);

class ProductRepository
{
    /** @return array<int, array{id:int, name:string, price:float, description:?string, image:?string}> */
    public function all(): array
    {
        $pdo = Connection::pdo();
        $stmt = $pdo->query('SELECT id, name, price, description, image FROM products ORDER BY id ASC');
        $rows = $stmt->fetchAll();

        $out = [];
        foreach ($rows as $r) {
            $out[] = [
                'id' => (int)$r['id'],
                'name' => (string)$r['name'],
                'price' => (float)$r['price'],
                'description' => $r['description'] !== null ? (string)$r['description'] : null,
                'image' => $r['image'] !== null ? (string)$r['image'] : null,
            ];
        }

        return $out;
    }

    public function find(int $id): ?array
    {
        $pdo = Connection::pdo();
        $stmt = $pdo->prepare('SELECT id, name, price, description, image FROM products WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $r = $stmt->fetch();

        if (!$r) {
            return null;
        }

        return [
            'id' => (int)$r['id'],
            'name' => (string)$r['name'],
            'price' => (float)$r['price'],
            'description' => $r['description'] !== null ? (string)$r['description'] : null,
            'image' => $r['image'] !== null ? (string)$r['image'] : null,
        ];
    }

    /**
     * Crée une commande + items dans la DB.
     */
    public function createOrderFromCart(string $customerName, string $customerEmail, CartRepository $cart): int
    {
        $cartItems = $cart->get();
        if (!$cartItems) {
            throw new RuntimeException('Cart vide');
        }

        $pdo = Connection::pdo();
        $pdo->beginTransaction();

        $total = $cart->total($this);

        // Robust: si schema ne contient pas customer_email, on fallback.
        try {
            $stmt = $pdo->prepare('INSERT INTO orders (customer_name, customer_email, status, total) VALUES (?, ?, ?, ?)');
            $stmt->execute([$customerName, $customerEmail, 'pending', $total]);
        } catch (Throwable $e) {
            $stmt = $pdo->prepare('INSERT INTO orders (customer_name, status, total) VALUES (?, ?, ?)');
            $stmt->execute([$customerName, 'pending', $total]);
        }

        $orderId = (int)$pdo->lastInsertId();

        $insertItem = $pdo->prepare(
            'INSERT INTO order_items (order_id, product_id, product_name, unit_price, qty, subtotal) VALUES (?, ?, ?, ?, ?, ?)'
        );

        foreach ($cartItems as $productId => $qty) {
            $p = $this->find((int)$productId);
            if (!$p) continue;

            $unitPrice = (float)$p['price'];
            $q = (int)$qty;
            $subtotal = $unitPrice * $q;

            $insertItem->execute([
                $orderId,
                (int)$productId,
                (string)$p['name'],
                $unitPrice,
                $q,
                $subtotal,
            ]);
        }

        $pdo->commit();
        return $orderId;
    }
}

