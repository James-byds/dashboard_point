<?php 
//remove entry from the api
$id = parseInt($_GET['id']);
$model= trim($_GET['model']);
//curl parameters
$params = [
  'filter' => json_encode([
    '_id' => $id
])
];

//curl request
$url = curl_init(apiUrlSolo . '/'.$model.'?'.http_build_query($params)); // API endpoint for fetching history items
curl_setopt($url, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
curl_setopt($url, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($url, CURLOPT_HTTPHEADER, [
  'Content-Type: application/json',
  'Accept: application/json'
]);
$response = curl_exec($url); // Execute the request
curl_close($url); // Close the cURL session
if($response === false) {
    $error = 'Failed to connect to the API.';
    exit;
}

// Decode the JSON response
$response = json_decode($response, true);
echo json_encode($response);
echo "Entry removed successfully!";
