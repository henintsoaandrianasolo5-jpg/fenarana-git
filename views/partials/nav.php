<?php
$cartCount = (int)($cartCount ?? 0);
$activeRoute = $activeRoute ?? '';
?>
<aside class="sidebar" aria-label="Navigation">
  <div class="sidebar__brand">FenArana</div>

  <nav class="sidebar__nav">
    <a class="sidebar__link <?= $activeRoute === '/' ? 'is-active' : '' ?>" href="/">Accueil</a>
    <a class="sidebar__link <?= $activeRoute === '/products' ? 'is-active' : '' ?>" href="/products">Produits</a>
    <a class="sidebar__link <?= $activeRoute === '/cart' ? 'is-active' : '' ?>" href="/cart">Panier (<?= $cartCount ?>)</a>
    <a class="sidebar__link <?= $activeRoute === '/checkout' ? 'is-active' : '' ?>" href="/checkout">Checkout</a>
  </nav>
</aside>

