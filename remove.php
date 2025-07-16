<?php 
require_once('functions.php');
//remove entry from the api
$id = $_GET['id'];
$model= trim($_GET['model']);
//curl request
$url = curl_init(apiUrlSolo . '/'.$model."/".$id); // API endpoint for fetching history items
curl_setopt($url, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
curl_setopt($url, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($url, CURLOPT_HTTPHEADER, [
  'api-key: '.$_SESSION['token'],
  'Content-Type: application/json',
  'Accept: application/json'
]);
$response = curl_exec($url); // Execute the request
display($url);
if($response === false) {
    $error = 'Failed to connect to the API.';
    exit;
  }
$response = json_decode($response, true);
echo json_encode($response);
display($response);
curl_close($url); // Close the cURL session

// Decode the JSON response
echo "Entry removed successfully!";
header('Location: dashboard.php');