<?php
require_once 'functions.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
else{
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
</head>
<body>
  <?php
  include 'nav.php';
  ?>
<h1 class="dashboard-title title">Dashboard</h1>
<p>Welcome, <?=($_SESSION['user']); ?>!</p>
<p>Your role: <?=($_SESSION['role']); ?></p>
<?php
  include 'search.php';
?>

<section id="table" class="flex">
  <h2>Historique du jour</h2>
  <div class="table-header grid box header">
    <div class="table-item column has-text-centered border box">Type de visite</div>
    <div class="table-item column has-text-centered border box">Référence</div>
    <div class="table-item column has-text-centered border box">Arrivée</div>
    <div class="table-item column has-text-centered border box">Date</div>
    <div class="table-item column has-text-centered border box">Départ</div>
    <div class="table-item column has-text-centered border box">Visiteur</div>
    <div class="table-item column has-text-centered border box">Controles</div>
  </div>
  <?php
  if (isset($_GET['query'])) {
    
    //convert form data to api format
    $year=substr($_GET['query'], 0, 4);
    $month=substr($_GET['query'], 5, 2);
    $day=substr($_GET['query'], 8, 2);
    $searchDate = $day."/".$month."/".$year;
    echo "<p>Search date: " . $searchDate . "</p>";
    date_search($searchDate);
  }
  else {
    define('TODAY', date('d/m/Y'));
    echo "<p>Today's date: " . TODAY . "</p>";
    // Build query parameters
    date_search(TODAY);
  }
  //get today's date
  ?>
  </ul>
</section>
</body>
</html>
<?php  
}
?>