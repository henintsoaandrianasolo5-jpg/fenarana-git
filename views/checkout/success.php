<?php
$orderId = $orderId ?? 0;
?>
<section class="page">
  <h2 class="page__title">Commande validée 🎉</h2>
  <p>Votre commande #<?= (int)$orderId ?> a été créée.</p>
  <a class="btn btn--ghost" href="/products">Continuer</a>
</section>

