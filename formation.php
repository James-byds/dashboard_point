<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formations</title>
</head>
<body>
  <?php
  include 'nav.php';
  ?>
  <h1>Formations</h1>
  <p>This is the formation page.</p>
  <?php
    $params = [
      'fields' => json_encode([
          '_modified' => 0,
          '_mby' => 0,
          '_created' => 0,
          '_state' => 0,
          '_cby' => 0
      ])
      ];
    model_display($params, "formations");
  ?>

</body>
</html>
