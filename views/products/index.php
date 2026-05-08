<?php
$products = $products ?? [];
?>
<section class="page">
  <h2 class="page__title">Produits</h2>

  <div class="grid">
    <?php foreach ($products as $p): ?>
      <article class="card">
        <img class="card__img" src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" />
        <div class="card__body">
          <h3 class="card__title"><?= htmlspecialchars($p['name']) ?></h3>
          <p class="card__desc"><?= htmlspecialchars($p['description']) ?></p>
          <div class="card__footer">
            <span class="card__price">€ <?= number_format((float)$p['price'], 2, ',', ' ') ?></span>
            <div class="card__actions">
              <a class="btn btn--ghost" href="/product?id=<?= (int)$p['id'] ?>">Détails</a>
              <form method="post" action="/cart/add">
                <input type="hidden" name="product_id" value="<?= (int)$p['id'] ?>" />
                <input type="hidden" name="qty" value="1" />
                <button class="btn btn--primary" type="submit">Ajouter</button>
              </form>
            </div>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

