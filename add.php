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