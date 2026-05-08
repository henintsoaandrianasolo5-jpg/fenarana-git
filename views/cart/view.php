<?php
$items = $items ?? [];
?>
<section class="page">
  <h2 class="page__title">Votre panier</h2>

  <?php if (count($items) === 0): ?>
    <p>Panier vide.</p>
    <a class="btn btn--ghost" href="/products">Continuer</a>
  <?php else: ?>
    <div class="cart">
      <?php foreach ($items as $it): ?>
        <div class="cart__row">
          <img class="cart__img" src="<?= htmlspecialchars($it['image']) ?>" alt="" />
          <div class="cart__meta">
            <div class="cart__name"><?= htmlspecialchars($it['name']) ?></div>
            <div class="cart__sub">€ <?= number_format((float)$it['unit_price'], 2, ',', ' ') ?> × <?= (int)$it['qty'] ?></div>
          </div>
          <div class="cart__total">€ <?= number_format((float)$it['subtotal'], 2, ',', ' ') ?></div>
          <form method="post" action="/cart/remove" class="cart__remove">
            <input type="hidden" name="product_id" value="<?= (int)$it['id'] ?>" />
            <button class="btn btn--danger" type="submit">Retirer</button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="cart__summary">
      <div class="cart__summaryTotal">Total: € <?= number_format((float)$cartTotal, 2, ',', ' ') ?></div>
      <a class="btn btn--primary" href="/checkout">Valider</a>
    </div>
  <?php endif; ?>
</section>

