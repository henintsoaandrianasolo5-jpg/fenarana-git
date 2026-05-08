<?php
$items = $items ?? [];
?>
<section class="page">
  <h2 class="page__title">Checkout</h2>

  <div class="checkout">
    <div class="checkout__left">
      <h3 class="sectionTitle">Vos articles</h3>
      <div class="checkout__list">
        <?php foreach ($items as $it): ?>
          <div class="checkout__item">
            <div class="checkout__itemName"><?= htmlspecialchars($it['name']) ?></div>
            <div class="checkout__itemQty">x<?= (int)$it['qty'] ?></div>
            <div class="checkout__itemPrice">€ <?= number_format((float)$it['subtotal'], 2, ',', ' ') ?></div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="checkout__total">Total: € <?= number_format((float)$cartTotal, 2, ',', ' ') ?></div>
    </div>

    <div class="checkout__right">
      <h3 class="sectionTitle">Infos client</h3>
      <form method="post" action="/checkout" class="form">
        <label>
          Nom
          <input type="text" name="customer_name" required />
        </label>
        <label>
          Email
          <input type="email" name="customer_email" required />
        </label>
        <button class="btn btn--primary" type="submit">Payer (demo)</button>
      </form>
      <p class="hint">(Middleware AuthMiddleware: si pas de session, redirection possible.)</p>
    </div>
  </div>
</section>

