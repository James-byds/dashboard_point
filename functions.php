<?php
require_once("config.php");
require_once("login.php");
/**
 * Affiche le contenu d'une variable de manière lisible
 *  Utile pour le débogue
 */
function display ($name) {
  if (DEBUG) :
  echo"<pre>";
  print_r($name);//print_r affiche le contenu de la variable et le détail pratique pour le débogage
  echo"</pre>";
  endif;
}


function model_display($params, $model) {
  //$params is an associative array
  $url = curl_init(apiUrl . '/'.$model.'?'.http_build_query($params)); // API endpoint for fetching history items
  curl_setopt($url, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
  curl_setopt($url, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $_SESSION['token'], // Use the session token for authentication
      'Accept: application/json',
      'Method: GET'
  ]);
  $response = curl_exec($url); // Execute the cURL request
  $modelItems = json_decode($response, true); // Decode the JSON response
  curl_close($url); // Close the cURL session
  
  echo "<p>I found these results:</p>
  <ul>
  ";
  if (!empty($modelItems)) :
    display($modelItems);
    foreach ($modelItems as $index => $array) {
      echo "<li>";
      echo "Index: " . $index . "<br>";
      foreach ($array as $key => $value) {
        if(is_array($value)) {
          //if is array, need to fetch api
          $firstOfIndex = array_key_first($value);//
          //curl request to fetch individual item
          if ($firstOfIndex !=="_model") {//check if array has subarray
            $model = $value[$firstOfIndex]['_model'];
            $id=$value[$firstOfIndex]['_id'];
          }
          else {//else stock values
            $model = $value['_model'];
            $id=$value['_id'];
          }
        $url = curl_init(apiUrlSolo . '/'.$model."/".$id); // API endpoint for fetching one item
        curl_setopt($url, CURLOPT_HTTPHEADER, [
              'Authorization: Bearer ' . $_SESSION['token'], // Use the session token for authentication
              'Accept: application/json',
              'Method: GET'
            ]);
            curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($url); // Execute the cURL request
            $searchModel = json_decode($response, true); // Decode the JSON response
            curl_close($url); // Close the cURL session
            if ($searchModel["name"]!=null && $key!="_id")echo "name: ".$searchModel["name"];
          }
          else if ($value!=null && $key!="_id")echo $key.": ".$value;
          echo "<br>";
        }
        echo"
        <div class='buttons'>
          <button class='delete-button' data-id='".$array['_id']."' data-model='".$model."'>Delete</button>
          <button class='edit-button' data-id='".$array['_id']."' data-model='".$model."'>Edit</button>
        </div>
        </li>";
      }
      echo "</ul>";
      echo "<button class='add-button' data-model='".$model."'>Add new ".$model."</button>";
      else :
        echo "No ".$model." found";
      endif;
    }
    
    function date_search ($date) {
    
     $params = [
          'filter' => json_encode(['date' => $date]),
          'fields' => json_encode([
              '_modified' => 0,
              '_mby' => 0,
              '_created' => 0,
              '_state' => 0,
              '_cby' => 0
          ])
      ];
      model_display($params, 'entries');
    }
    
    ?>