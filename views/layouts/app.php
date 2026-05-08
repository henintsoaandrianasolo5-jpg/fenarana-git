<?php
$activeRoute = $activeRoute ?? '';
$cartCount = (int)($cartCount ?? 0);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FenArana</title>
  <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body>
  <div class="layout">
    <?php require __DIR__ . '/../partials/nav.php'; ?>

    <main class="content">
      <?php require __DIR__ . '/../' . $template . '.php'; ?>
    </main>
  </div>
</body>
</html>

