<?php
require_once("functions.php");
include 'nav.php';
if (!isset($_GET['model'])) {
  //*header('Location: dashboard.php');
  //exit;
}
$model = trim($_GET['model']);
switch ($model) {
  case 'formations':
    $champs = [
      //fieldname => input type
      "subject"=>"text",
      "formateur"=>"select",//select from staff members
      "local"=>"text",
      "name"=>"text",
    ];
    break;
  case 'staff':
    $champs = [
      //fieldname => input type
      "name"=>"text",
      "firstname"=>"text",
      "office"=>"text",
      "phone"=>"tel"//pattern = "[0-9]{10}"
    ];
    break;
  default:
    $champs = [];
    break;
}
?>
<form action="add.php" method="post">


  <?php
  foreach ($champs as $key => $value) {
    echo '<label for="' . $key . '">' . $key;
    echo '<input type="' . $value . '" name="' . $key . '">';
    echo'</label>';
  }
  //getdata
  $url = curl_init(apiUrlSolo . '/'.$model); // API endpoint for fetching history items
  curl_setopt($url, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
  curl_setopt($url, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $_SESSION['token'], // Use the session token for authentication
      'Accept: application/json',
      'Method: GET'
  ]);
  /*$response = curl_exec($url); // Execute the cURL request
  $modelItems = json_decode($response, true); // Decode the JSON response
  curl_close($url); // Close the cURL session*/
  ?>
  <button type="submit">Add</button>
</form>

<?php
function add($data, $model) {
  $url = curl_init(apiUrlSolo . '/'.$model); // API endpoint for adding history items
  curl_setopt($url, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
  curl_setopt($url, CURLOPT_POST, true); // Set the request method to POST
  curl_setopt($url, CURLOPT_POSTFIELDS, json_encode($data)); // Data to be sent in the POST request body
  curl_setopt($url, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
  ]);
  $response = curl_exec($url); // Execute the cURL request
  curl_close($url); // Close the cURL session
  if($response === false) {
      $error = 'Failed to connect to the API.';
      exit;
  }

  // Decode the JSON response
  $response = json_decode($response, true);
  echo json_encode($response);
  echo "Entry added successfully!";
   echo '<script>setTimeout(function(){ window.location.href = "dashboard.php"; }, 1000);</script>';
}
?>