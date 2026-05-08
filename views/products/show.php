<?php
$product = $product ?? null;
?>
<section class="page">
  <a class="link" href="/products">← Retour</a>

  <div class="product">
    <div class="product__media">
      <img class="product__img" src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
    </div>

    <div class="product__info">
      <h2 class="product__title"><?= htmlspecialchars($product['name']) ?></h2>
      <p class="product__desc"><?= htmlspecialchars($product['description']) ?></p>
      <div class="product__price">€ <?= number_format((float)$product['price'], 2, ',', ' ') ?></div>

      <form method="post" action="/cart/add" class="product__actions">
        <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>" />
        <input type="hidden" name="qty" value="1" />
        <button class="btn btn--primary" type="submit">Ajouter au panier</button>
      </form>

      <a class="btn btn--ghost" href="/cart">Voir panier</a>
    </div>
  </div>
</section>

