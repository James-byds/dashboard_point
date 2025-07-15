<?php
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff</title>
</head>
<body>
  <?php
  include 'nav.php';
  ?>
  <h1>Staff</h1>
  <p>This is the staff page.</p>
  <section id="table">
  <h2>Membres du personnel</h2>
  <div class="table-header">
    <div class="table-item">Nom</div>
    <div class="table-item">Prénom</div>
    <div class="table-item">Bureau</div>
    <div class="table-item">Téléphone</div>
    <div class="table-item">Type</div>
  </div>

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
      get_api_data('staff', $params);
  ?>
</section>
</body>
</html>
