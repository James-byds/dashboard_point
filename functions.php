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


function model_display($modelItems, $model) {
  echo "<p>I found these results:</p>
  <ul class='flex list'>
  ";
  if (!empty($modelItems)) :
    display($modelItems);
    foreach ($modelItems as $index => $array) {
      echo "<li class='card grid has-text-centered p-1 m-1'>
      ";
      foreach ($array as $key => $value) {
        if(is_array($value)) {
          //if is array, need to fetch api
          $firstOfIndex = array_key_first($value);//
          //curl request to fetch individual item
          if ($firstOfIndex !=="_model") {//check if array has subarray
            $model_search = $value[$firstOfIndex]['_model'];
            $id=$value[$firstOfIndex]['_id'];
          }
          else {//else stock values
            $model_search = $value['_model'];
            $id=$value['_id'];
          }
        $url = curl_init(apiUrlSolo . '/'.$model_search."/".$id); // API endpoint for fetching one item
        curl_setopt($url, CURLOPT_HTTPHEADER, [
              'Authorization: Bearer ' . $_SESSION['token'], // Use the session token for authentication
              'Accept: application/json',
              'Method: GET'
            ]);
            curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($url); // Execute the cURL request
            $searchModel = json_decode($response, true); // Decode the JSON response
            curl_close($url); // Close the cURL session
            if (isset($searchModel["name"]))echo "<p>name: ".$searchModel["name"];
            else if (isset($searchModel["firstname"]))echo "<p>firstname: ".$searchModel["firstname"];
          }
          else if ( $key!="_id")echo "<p>".$key.": ".$value;
        }
        echo '
        <div class="buttons">
        <a href="./add.php?id='.$array['_id'].'&model='.$model.'" class="button is-light is-link">
        EDIT
        </a>
        <a href="./remove.php?id='.$array['_id'].'&model='.$model.'" class="button is-light is-link">
        DELETE
        </a>
        </div>
        ';
/*<button class="delete-button" data-id="'.$array['_id'].'" data-model="'.$model.'">Delete</button>
<form action="./add.php?id='.$array['_id'].'&model='.$model.'" method="get">
  <button input type="submit" class="edit-button" data-id="'.$array['_id'].'" data-model="'.$model.'">Edit</button>
</form>*/
echo'</li>';
      }
      echo "</ul>";
      echo "
      <form class='mx-auto'action='./add.php?model=".$model."' method='get'>
      <button type = 'submit' name='model' class='add-button button is-light flex' data-model='".$model."' value='".$model."'>Add new ".$model."</button>
      </form>";
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
      get_api_data('entries', $params);
    }
    

    
function get_api_data($method, $params, $display = true, $apiUrl =apiUrl) {
  $params['fields'] = json_encode([
      '_modified' => 0,
      '_mby' => 0,
      '_created' => 0,
      '_state' => 0,
      '_cby' => 0
  ]);
  //$params is an associative array
  $url = curl_init($apiUrl . '/'.$method.'?'.http_build_query($params)); // API endpoint for fetching history items
  curl_setopt($url, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
  curl_setopt($url, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $_SESSION['token'], // Use the session token for authentication
      'Accept: application/json',
      'Method: GET'
  ]);
  $response = curl_exec($url); // Execute the cURL request
  $modelItems = json_decode($response, true); // Decode the JSON response
  curl_close($url); // Close the cURL session
  if($display) model_display($modelItems, $method);
  else {
    return $modelItems;
  }
}
    ?>