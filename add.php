<?php
require_once("functions.php");
include 'nav.php';
if (!isset($_GET['model'])) {
  //header('Location: dashboard.php');
  //exit;
}
$model = trim($_GET['model']);
switch ($model) {
  case 'formations':
    $champs = [
      //fieldname => input type
      "subject"=>"text",
      //"formateur"=>"select",//select from staff members done later
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
<form action="add.php?model=<?=$model?>" method="post">

  <?php
  foreach ($champs as $key => $value) {
    echo '<label for="' . $key . '">' . $key;
    echo '<input type="' . $value . '" name="' . $key . '">';
    echo'</label>';
  }
  //getdata for select inputs
  if ($model == "formations") {
    echo '<label for="formateur">Formateur</label> <select name="formateur" id="formateur">';
    $data = get_api_data("staff", [], false);
    display($data);
    foreach ($data as $key => $value) {
      echo '<option value="' . $value['_id'] . '">' . $value['name'] . ' ' . $value['firstname'] . '</option>';
    }
    echo '</select>';
  }
  ?>
  <button type="submit">Add</button>
</form>

<?php
function add($data, $model) {
  echo apiUrlSolo;
  $url = curl_init(apiUrlSolo . '/'.$model); // API endpoint for adding history items
  curl_setopt($url, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
  curl_setopt($url, CURLOPT_POST, true); // Set the request method to POST
  curl_setopt($url, CURLOPT_POSTFIELDS, json_encode($data)); // Data to be sent in the POST request body
  curl_setopt($url, CURLOPT_HTTPHEADER, [
    'api-key: '.$_SESSION['token'],
    //apiKey 
    'Content-Type: application/json',
    'Accept: application/json'
  ]);
  $response = curl_exec($url); // Execute the cURL request
  curl_close($url); // Close the cURL session
  if($response === false) {
      $error = 'Failed to connect to the API.';
      //exit;
    }
  $response = json_decode($response, true);
  if(isset($response['error'])) {
    echo json_encode($response['error']);
  }
  // Decode the JSON response
  else {
  echo json_encode($response);
  echo "Entry added successfully!";
  //echo '<script>setTimeout(function(){ window.location.href = "dashboard.php"; }, 1000);</script>';
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //print_r($_POST);
  $data['data'] = $_POST;
  echo $_SESSION['token'];
  //echo json_encode($data);
  print_r($data);
  add($data, $model);
}
?>